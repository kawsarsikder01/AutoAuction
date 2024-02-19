<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Page;
use App\Models\PlanPurchaseHistory;
use App\Models\Transaction;
use App\Traits\PaymentValidationCheck;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use Stevebauman\Purify\Facades\Purify;
use App\Traits\Notify;

class PlanPurchaseControlller extends Controller
{
    use PaymentValidationCheck , Notify;
    public  function purchasePlan ($id)
    {
      try {
        $plan = Plan::findOrFail($id);

      if(Auth::user()->plan && $plan->price < Auth::user()->plan->price){
        return back()->with('warning',"You Can Not Downgrade Your Plan");
      }
        if(Auth::user()->plan){
            throw new \Exception('not found');
        }
       $user =  Auth::user();
        if($user->plan && $user->plan->plan_id == $id){
            throw new \Exception('not found');
          }
          session(['plan_id' => $plan->id]);
        $data['plan_id'] =  $id;
        $data['plan'] = $plan;
        $data['pageSeo'] = Page::where('name', 'payment option')->select('page_title','breadcrumb_image','breadcrumb_image_driver')->first();
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
       return view(template().'plans.selectGateway',$data);
      } catch (\Exception $exception) {
        return view(template().'errors.404');
      }
    }

    public function checkAmount(Request $request)
    {
        if ($request->ajax()) {
            $amount = $request->amount;
            $selectedCurrency = $request->selected_currency;
            $selectGateway = $request->select_gateway;
            $selectedCryptoCurrency = $request->selectedCryptoCurrency;
            $data = $this->checkAmountValidate($amount, $selectedCurrency, $selectGateway, $selectedCryptoCurrency);
            return response()->json($data);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function checkAmountValidate($amount, $selectedCurrency, $selectGateway, $selectedCryptoCurrency = null)
    {
        $selectGateway = Gateway::where('id', $selectGateway)->where('status', 1)->first();
        if (!$selectGateway) {
            return ['status' => false, 'message' => "Payment method not available for this transaction"];
        }


        if ($selectGateway->currency_type == 1) {
            $selectedCurrency = array_search($selectedCurrency, $selectGateway->supported_currency);
            if ($selectedCurrency !== false) {
                $selectedPayCurrency = $selectGateway->supported_currency[$selectedCurrency];
            } else {
                return ['status' => false, 'message' => "Please choose the currency you'd like to use for payment"];
            }
        }

        if ($selectGateway->currency_type == 0) {
            $selectedCurrency = array_search($selectedCryptoCurrency, $selectGateway->supported_currency);
            if ($selectedCurrency !== false) {
                $selectedPayCurrency = $selectGateway->supported_currency[$selectedCurrency];
            } else {
                return ['status' => false, 'message' => "Please choose the currency you'd like to use for payment"];
            }
        }

        if ($selectGateway) {
            $receivableCurrencies = $selectGateway->receivable_currencies;
            if (is_array($receivableCurrencies)) {
                if ($selectGateway->id < 999) {
                    $currencyInfo = collect($receivableCurrencies)->where('name', $selectedPayCurrency)->first();
                } else {
                    if ($selectGateway->currency_type == 1) {
                        $currencyInfo = collect($receivableCurrencies)->where('currency', $selectedPayCurrency)->first();
                    } else {
                        $currencyInfo = collect($receivableCurrencies)->where('currency', $selectedCryptoCurrency)->first();
                    }
                }
            } else {
                return null;
            }
        }


        $currencyType = $selectGateway->currency_type;
        $limit = $currencyType == 0 ? 8 : 2;
        $amount = getAmount($amount*$currencyInfo->conversion_rate , $limit);
        $status = false;

        if ($currencyInfo) {
            $percentage = getAmount($currencyInfo->percentage_charge, $limit);
            $percentage_charge = getAmount(($amount * $percentage) / 100, $limit);
            $fixed_charge = getAmount($currencyInfo->fixed_charge, $limit);
            $min_limit = getAmount($currencyInfo->min_limit, $limit);
            $max_limit = getAmount($currencyInfo->max_limit, $limit);
            $charge = getAmount($percentage_charge + $fixed_charge, $limit);
        }

        $conversion_rate =  $currencyInfo->conversion_rate?? 1;
        $basicControl = basicControl();
        $payable_amount = getAmount($amount + $charge, $limit);
        $amount_in_base_currency = getAmount($payable_amount / $currencyInfo->conversion_rate ?? 1, $limit);

        if (!$amount) {
            $message = "minimum payment $min_limit and maximum payment limit $max_limit";
        } else {
            $status = true;
            $message = "Amount : $amount" . " " . $selectedPayCurrency;
        }

        $data['status'] = $status;
        $data['message'] = $message;
        $data['fixed_charge'] = $fixed_charge;
        $data['percentage'] = $percentage;
        $data['percentage_charge'] = $percentage_charge;
        $data['min_limit'] = $min_limit;
        $data['max_limit'] = $max_limit;
        $data['payable_amount'] = $payable_amount;
        $data['charge'] = $charge;
        $data['amount'] = $amount;
        $data['conversion_rate'] = $currencyInfo->conversion_rate ?? 1;
        $data['amount_in_base_currency'] = number_format($amount_in_base_currency, 2);
        $data['currency'] = ($selectGateway->currency_type == 1) ? ($currencyInfo->name ?? $currencyInfo->currency) : "USD";
        $data['base_currency'] = $basicControl->base_currency;
        $data['currency_limit'] = $limit;


        return $data;
    }

public function confirmPlan(Request $request)
{
    $plan_id = session('plan_id');
    if ($plan_id != $request->plan_id){
        abort(403);
    }
    $request->validate([
        'plan_id' => 'required',
        'gateway_id'=>'required',
    ]);
    try {
        $plan = Plan::findOrFail($request->plan_id);

        if ($request->gateway_id == 'website_wallet' && $plan->price > Auth::user()->balance){
            return back()->with('error','Your balance is low please deposit now');
        }
        if ($request->gateway_id != 'website_wallet'){
            $amount = $plan->price;
            $gateway = $request->gateway_id;
            $currency = $request->supported_currency;
            $cryptoCurrency= $request->supported_crypto_currency;
            $checkAmount = $this->checkAmountValidate($amount,  $currency ,$gateway, $cryptoCurrency);

            $checkAmountValidate = $this->validationCheck($checkAmount['amount'], $gateway, $currency, $cryptoCurrency);

            if ($checkAmountValidate['status'] == 'error') {
                return back()->with('error', $checkAmountValidate['msg']);
            }
        }
        $deposit = Deposit::create([
            'user_id' => Auth::user()->id,
            'depositable_id' => $plan->id,
            'depositable_type' => 'App\Models\Plan',
            'payment_method_id' => $checkAmountValidate['data']['gateway_id']??'Wallet',
            'payment_method_currency' => $checkAmountValidate['data']['currency']??basicControl()->base_currency,
            'amount' => $checkAmountValidate['data']['amount']??$plan->price,
            'percentage_charge' => $checkAmountValidate['data']['percentage_charge']??'',
            'fixed_charge' => $checkAmountValidate['data']['fixed_charge']??'',
            'payable_amount' => $checkAmountValidate['data']['payable_amount']??$plan->price,
            'base_currency_charge' => $checkAmountValidate['data']['base_currency_charge']??'',
            'payable_amount_in_base_currency' => $checkAmountValidate['data']['payable_amount_base_in_currency']??$plan->price,
            'trx_id' => strRandom(),
            'status' => 0,
        ]);
        $type = 'payment';

        if ($request->gateway_id == 'website_wallet'){
           $walletPayment =  $this->walletPayment($plan_id,$deposit->trx_id,$deposit->id);

           if ($walletPayment == true){
               return  view('success');
           }else{
               return back()->with('error',$walletPayment);
           }
        }
        return redirect(route('payment.process', [$deposit->trx_id,$type]));

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

public function walletPayment($plan_id,$trx_id,$deposit_id)
{
    $user = Auth::user();
    try {
        if(!$user->plan){
            $plan = Plan::findOrFail($plan_id);
            if ($plan){
                $planPurchaseHistory = new PlanPurchaseHistory();
                $planPurchaseHistory->plan_name = $plan->plan_name;
                $planPurchaseHistory->plan_id = $plan->id;
                $planPurchaseHistory->user_id = $user->id;
                $planPurchaseHistory->price =  $plan->price;
                $planPurchaseHistory->noOfListing = $plan->number_of_listing;
                $planPurchaseHistory->noOfMaxImg = $plan->number_of_images;
                $planPurchaseHistory->access_auction = $plan->access_auction;
                $planPurchaseHistory->customer_support = $plan->customer_support;
                $planPurchaseHistory->promoted_listing = $plan->promoted_listing;
                $planPurchaseHistory->top_search_result = $plan->top_search_result;
                $planPurchaseHistory->share_other_platform = $plan->share_other_platform;
                $planPurchaseHistory->trx_id = $trx_id;
                $planPurchaseHistory->status = 1;
                $planPurchaseHistory->payment_method =  'Wallet';
                $planPurchaseHistory->purchase_date = Carbon::now()->toDateTimeString();
                if ($plan->expiry_time_type == 'days' || $plan->expiry_time_type == 'day') {
                    $planPurchaseHistory->expiry_date = Carbon::now()->addDays($plan->expiry_time);
                } elseif ($plan->expiry_time_type == 'months' || $plan->expiry_time_type == 'month') {
                    $planPurchaseHistory->expiry_date = Carbon::now()->addMonths($plan->expiry_time);
                } elseif ($plan->expiry_time_type == 'years' || $plan->expiry_time_type == 'year') {
                    $planPurchaseHistory->expiry_date = Carbon::now()->addYears($plan->expiry_time);
                } else {
                    $user->expire_date = null;
                }
            }
            $planPurchaseHistory->save();
            $user->purchased_plan_id = $planPurchaseHistory->id;
            $user->balance = $user->balance - $plan->price;
            $user->total_listed_car = 0;
            $user->update();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $plan->price;
            $transaction->charge = 0;
            $transaction->balance = getAmount($user->balance);
            $transaction->trx_type = '-';
            $transaction->trx_id = $trx_id;
            $transaction->remarks = 'Purchase Plan Via ' . 'Wallet';
            $transaction->transactional_id = $deposit_id;
            $transaction->transactional_type = 'App\Models\Plan';
            $transaction->save();

            $params = [
                'username' => $user->username,
                'amount' => currencyPosition($plan->price),
                'trx_id' => $trx_id,
            ];
            $actionAdmin = [
                "name" => $user->firstname . ' ' . $user->lastname,
                "image" => getFile($user->image_driver, $user->image),
                "link" => route('admin.transaction'),
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $firebaseAction = route('admin.transaction');
            $this->adminMail('PLAN_PURCHASE_USER_ADMIN', $params);
            $this->adminPushNotification('PLAN_PURCHASE_USER_ADMIN', $params, $actionAdmin);
            $this->adminFirebasePushNotification('PLAN_PURCHASE_USER_ADMIN', $params, $firebaseAction);
        }elseif($user->plan){
            $plan = Plan::findOrFail($plan_id);
            if ($plan){
                $oldPurchasedPlun = $user->plan;
                $oldPurchasedPlun->status = 0;
                $oldPurchasedPlun->update();
                $planPurchaseHistory = new PlanPurchaseHistory();
                $planPurchaseHistory->plan_name = $plan->plan_name;
                $planPurchaseHistory->plan_id = $plan->id;
                $planPurchaseHistory->user_id = $user->id;
                $planPurchaseHistory->price =  $plan->price;
                $planPurchaseHistory->noOfListing = $plan->number_of_listing;
                $planPurchaseHistory->noOfMaxImg = $plan->number_of_images;
                $planPurchaseHistory->access_auction = $plan->access_auction;
                $planPurchaseHistory->customer_support = $plan->customer_support;
                $planPurchaseHistory->promoted_listing = $plan->promoted_listing;
                $planPurchaseHistory->top_search_result = $plan->top_search_result;
                $planPurchaseHistory->share_other_platform = $plan->share_other_platform;
                $planPurchaseHistory->status = 1;
                $planPurchaseHistory->trx_id = $trx_id;
                $planPurchaseHistory->payment_method =   'Wallet';
                $planPurchaseHistory->purchase_date = Carbon::now()->toDateTimeString();
                if ($plan->expiry_time_type == 'days' || $plan->expiry_time_type == 'day') {
                    $planPurchaseHistory->expiry_date = Carbon::now()->addDays($plan->expiry_time);
                } elseif ($plan->expiry_time_type == 'months' || $plan->expiry_time_type == 'month') {
                    $planPurchaseHistory->expiry_date = Carbon::now()->addMonths($plan->expiry_time);
                } elseif ($plan->expiry_time_type == 'years' || $plan->expiry_time_type == 'year') {
                    $planPurchaseHistory->expiry_date = Carbon::now()->addYears($plan->expiry_time);
                } else {
                    $user->expire_date = null;
                }
            }
            $planPurchaseHistory->save();
            $user->purchased_plan_id = $planPurchaseHistory->id;
            $user->balance = $user->balance - $plan->price;
            $user->total_listed_car = 0;
            $user->update();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $plan->price;
            $transaction->charge = 0;
            $transaction->balance = getAmount($user->balance);
            $transaction->trx_type = '-';
            $transaction->trx_id = $trx_id;
            $transaction->remarks = 'Purchase Plan Via ' . 'Wallet';
            $transaction->transactional_id = $deposit_id;
            $transaction->transactional_type = 'App\Models\Plan';
            $transaction->save();

            $params = [
                'username' => $user->username,
                'amount' => currencyPosition($plan->price),
                'trx_id' => $trx_id,
            ];
            $actionAdmin = [
                "name" => $user->firstname . ' ' . $user->lastname,
                "image" => getFile($user->image_driver, $user->image),
                "link" => "#",
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $firebaseAction = "#";
            $this->adminMail('PLAN_UPGRADE_USER_ADMIN', $params);
            $this->adminPushNotification('PLAN_UPGRADE_USER_ADMIN', $params, $actionAdmin);
            $this->adminFirebasePushNotification('PLAN_UPGRADE_USER_ADMIN', $params, $firebaseAction);
        }

        return true;
    }catch (\Exception $exception){
        return $exception->getMessage();
    }
}



    public  function upgradePlan($id)
    {
        try {
            $user = Auth::user();
            $plan = Plan::findOrFail($id);
            if(!$user->plan){
                abort(403);
            }
            if ($user->plan->expiry_date > now()->format('Y-m-d H:i:s')){
                if ($user->plan->plan_id == $id){
                    abort(403);
                }elseif( $plan->price < Auth::user()->plan->price){
                    abort(403);
                }
            }
            session(['plan_id' => $plan->id]);
            $data['plan_id'] =  $id;
            $data['plan'] = $plan;
            $data['pageSeo'] = Page::where('name', 'payment option')->select('page_title','breadcrumb_image','breadcrumb_image_driver')->first();
            $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
            return view(template().'plans.selectGateway',$data);
        }catch (\Exception $exception){
            abort(403);
        }
    }
    public function purchaseHistory()
    {
        $user = Auth::user();
        if(!$user->plan){
            abort(403);
        }
        $purchaseHistorys = PlanPurchaseHistory::where('user_id',Auth::user()->id)->paginate(basicControl()->paginate);
        return view(template().'user.pages.purchaseHistory',compact('purchaseHistorys'));
    }
}
