<?php

namespace App\Services;


use App\Models\Fund;
use App\Models\Plan;
use App\Models\PlanPurchaseHistory;
use App\Models\Transaction;
use App\Traits\Notify;
use Illuminate\Support\Carbon;

class BasicService
{
    use Notify;

    public function setEnv($value)
    {
        $envPath = base_path('.env');
        $env = file($envPath);
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            $env[$env_key] = array_key_exists($entry[0], $value) ? $entry[0] . "=" . $value[$entry[0]] . "\n" : $env_value;
        }
        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);
    }

    public function preparePaymentUpgradation($deposit)
    {
        $deposit->status = 1;
        $deposit->save();

        if ($deposit->user && $deposit->depositable_type == Fund::class) {

                $user = $deposit->user;
                $user->balance += $deposit->payable_amount_in_base_currency;
                $user->save();
            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->payable_amount_in_base_currency;
            $transaction->charge = getAmount($deposit->base_currency_charge);
            $transaction->balance = getAmount($user->balance);
            $transaction->trx_type = '+';
            $transaction->trx_id = $deposit->trx_id;
            $transaction->remarks = 'Deposit Via ' . optional($deposit->gateway)->name;
            $transaction->transactional_type = 'App\Models\Plan';
            $deposit->transactional()->save($transaction);

            $params = [
                'amount' => currencyPosition($deposit->payable_amount_in_base_currency),
                'transaction' => $deposit->trx_id,
            ];

            $action = [
                "link" => route('user.fund.index'),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $firebaseAction = route('user.fund.index');
            $this->sendMailSms($deposit->user, 'ADD_FUND_USER_USER', $params);
            $this->userPushNotification($deposit->user, 'ADD_FUND_USER_USER', $params, $action);
            $this->userFirebasePushNotification($deposit->user, 'ADD_FUND_USER_USER', $params, $firebaseAction);

            $params = [
                'username' => optional($deposit->user)->username,
                'amount' => currencyPosition($deposit->payable_amount_in_base_currency),
                'transaction' => $deposit->trx_id,

            ];
            $actionAdmin = [
                "name" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                "link" => route('admin.transaction'),
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $firebaseAction = route('admin.transaction');
            $this->adminMail('ADD_FUND_USER_ADMIN', $params, $action);
            $this->adminPushNotification('ADD_FUND_USER_ADMIN', $params, $actionAdmin);
            $this->adminFirebasePushNotification('ADD_FUND_USER_ADMIN', $params, $firebaseAction);
        }elseif ($deposit->depositable_type == Plan::class && $deposit->depositable_id){
            $user = $deposit->user;
            if(!$user->plan){
                $plan = Plan::findOrFail($deposit->depositable_id);
                if ($plan){


                    $transaction = new Transaction();
                    $transaction->user_id = $deposit->user_id;
                    $transaction->amount = $deposit->payable_amount_in_base_currency;
                    $transaction->charge = getAmount($deposit->base_currency_charge);
                    $transaction->balance = getAmount($user->balance);
                    $transaction->trx_type = '-';
                    $transaction->trx_id = $deposit->trx_id;
                    $transaction->remarks = 'Deposit Via ' . optional($deposit->gateway)->name;
                    $transaction->transactional_type = 'App\Models\Plan';
                    $deposit->transactional()->save($transaction);
                    $deposit->save();


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
                    $planPurchaseHistory->trx_id = $deposit->trx_id;
                    $planPurchaseHistory->status = 1;
                    $planPurchaseHistory->payment_method =  optional($deposit->gateway)->name;
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
                $user->total_listed_car = 0;
                $user->update();

                $params = [
                    'username' => optional($deposit->user)->username,
                    'amount' => currencyPosition($deposit->payable_amount_in_base_currency),
                    'trx_id' => $deposit->trx_id,
                ];
                $actionAdmin = [
                    "name" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                    "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                    "link" => route('admin.transaction'),
                    "icon" => "fas fa-ticket-alt text-white"
                ];

                $firebaseAction = route('admin.transaction');
                $this->adminMail('PLAN_PURCHASE_USER_ADMIN', $params);
                $this->adminPushNotification('PLAN_PURCHASE_USER_ADMIN', $params, $actionAdmin);
                $this->adminFirebasePushNotification('PLAN_PURCHASE_USER_ADMIN', $params, $firebaseAction);
            }elseif($user->plan){
                $plan = Plan::findOrFail($deposit->depositable_id);
                if ($plan){

                    $transaction = new Transaction();
                    $transaction->user_id = $deposit->user_id;
                    $transaction->amount = $deposit->payable_amount_in_base_currency;
                    $transaction->charge = getAmount($deposit->base_currency_charge);
                    $transaction->balance = getAmount($user->balance);
                    $transaction->trx_type = '-';
                    $transaction->trx_id = $deposit->trx_id;
                    $transaction->remarks = 'Deposit Via ' . optional($deposit->gateway)->name;
                    $transaction->transactional_type = 'App\Models\Plan';
                    $deposit->transactional()->save($transaction);
                    $deposit->save();

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
                    $planPurchaseHistory->trx_id = $deposit->trx_id;
                    $planPurchaseHistory->payment_method =  optional($deposit->gateway)->name;
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
                $user->total_listed_car = 0;
                $user->update();

                $params = [
                    'username' => optional($deposit->user)->username,
                    'amount' => currencyPosition($deposit->payable_amount_in_base_currency),
                    'trx_id' => $deposit->trx_id,
                ];
                $actionAdmin = [
                    "name" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                    "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                    "link" => route('admin.transaction'),
                    "icon" => "fas fa-ticket-alt text-white"
                ];

                $firebaseAction = route('admin.transaction');
                $this->adminMail('PLAN_UPGRADE_USER_ADMIN', $params);
                $this->adminPushNotification('PLAN_UPGRADE_USER_ADMIN', $params, $actionAdmin);
                $this->adminFirebasePushNotification('PLAN_UPGRADE_USER_ADMIN', $params, $firebaseAction);
            }
        }

        return true;

    }

    public function cryptoQR($wallet, $amount, $crypto = null)
    {
        $varb = $wallet . "?amount=" . $amount;
        return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8";
    }
}
