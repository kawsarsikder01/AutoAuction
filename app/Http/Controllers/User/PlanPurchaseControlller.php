<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Page;
use App\Traits\PaymentValidationCheck;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use Stevebauman\Purify\Facades\Purify;

class PlanPurchaseControlller extends Controller
{
    use PaymentValidationCheck;
    public  function purchasePlan ($id)
    {
      $plan = Plan::find($id);

      if(Auth::user()->plan && $plan->price < Auth::user()->plan->price){
        return back()->with('warning',"You Can Not Downgrade Your Plan");
      }
        if(Auth::user()->plan){
            return  abort(404);
        }
       $user =  Auth::user();
        if($user->plan_id == $id){
            return abort(404);
          }

        $data['plan_id'] =  $id;
        $data['plan'] = $plan;
        $data['pageSeo'] = Page::where('name', 'payment option')->select('page_title','breadcrumb_image','breadcrumb_image_driver')->first();
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
       return view(template().'selectGateway',$data);
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
    $request->validate([
        'plan_id' => 'required',
        'gateway_id'=>'required',
        'supported_currency' => 'required'
    ]);
    $plan = Plan::find($request->plan_id);
    $amount = $plan->price;
    $gateway = $request->gateway_id;
    $currency = $request->supported_currency;
    $cryptoCurrency= $request->supported_crypto_currency;

    try {
        $checkAmount = $this->checkAmountValidate($amount,  $currency ,$gateway, $cryptoCurrency);

        $checkAmountValidate = $this->validationCheck($checkAmount['amount'], $gateway, $currency, $cryptoCurrency);

        if ($checkAmountValidate['status'] == 'error') {
            return back()->with('error', $checkAmountValidate['msg']);
        }
        $deposit = Deposit::create([
            'user_id' => Auth::user()->id,
            'depositable_id' => $plan->id,
            'depositable_type' => 'App\Models\Plan',
            'payment_method_id' => $checkAmountValidate['data']['gateway_id'],
            'payment_method_currency' => $checkAmountValidate['data']['currency'],
            'amount' => $checkAmountValidate['data']['amount'],
            'percentage_charge' => $checkAmountValidate['data']['percentage_charge'],
            'fixed_charge' => $checkAmountValidate['data']['fixed_charge'],
            'payable_amount' => $checkAmountValidate['data']['payable_amount'],
            'base_currency_charge' => $checkAmountValidate['data']['base_currency_charge'],
            'payable_amount_in_base_currency' => $checkAmountValidate['data']['payable_amount_base_in_currency'],
            'trx_id' => strRandom(),
            'status' => 0,
        ]);
        $type = 'payment';
        return redirect(route('payment.process', [$deposit->trx_id,$type]));

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}





    public  function upgradePlan($id)
    {
        $user = Auth::user();

        if(!$user->plan){
            return abort(404);
        }
        if ($user->plan->id == $id){
            return abort(404);
        }
        $plan = Plan::find($id);
        $data['plan_id'] =  $id;
        $data['plan'] = $plan;
        $data['pageSeo'] = Page::where('name', 'payment option')->select('page_title','breadcrumb_image','breadcrumb_image_driver')->first();
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
        return view(template().'selectGateway',$data);
    }



    public function purch($id)
    {



    }
}
