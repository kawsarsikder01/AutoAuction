<?php

namespace App\Services;


use App\Models\Transaction;
use App\Traits\Notify;
use GPBMetadata\Google\Api\Auth;

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

        if ($deposit->user) {
            $user = $deposit->user;
            $user->balance += $deposit->amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->payable_amount_in_base_currency;
            $transaction->charge = getAmount($deposit->base_currency_charge);
            $transaction->balance = getAmount($user->balance);
            $transaction->trx_type = '+';
            $transaction->trx_id = $deposit->trx_id;
            $transaction->remarks = 'Deposit Via ' . optional($deposit->gateway)->name;
            $deposit->transactional()->save($transaction);
            $deposit->save();

            $params = [
                'amount' => currencyPosition($deposit->amount),
                'transaction' => $deposit->trx_id,
            ];

            $action = [
                "link" => "#",
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $firebaseAction = '#';
            $this->sendMailSms($deposit->user, 'ADD_FUND_USER_USER', $params);
            $this->userPushNotification($deposit->user, 'ADD_FUND_USER_USER', $params, $action);
            $this->userFirebasePushNotification($deposit->user, 'ADD_FUND_USER_USER', $params, $firebaseAction);

            $params = [
                'username' => optional($deposit->user)->username,
                'amount' => currencyPosition($deposit->amount),
                'transaction' => $deposit->trx_id,
            ];
            $actionAdmin = [
                "name" => optional($deposit->user)->firstname . ' ' . optional($deposit->user)->lastname,
                "image" => getFile(optional($deposit->user)->image_driver, optional($deposit->user)->image),
                "link" => "#",
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $firebaseAction = "#";
            $this->adminMail('ADD_FUND_USER_ADMIN', $params, $action);
            $this->adminPushNotification('ADD_FUND_USER_ADMIN', $params, $actionAdmin);
            $this->adminFirebasePushNotification('ADD_FUND_USER_ADMIN', $params, $firebaseAction);
        }

        return true;

    }

    public function cryptoQR($wallet, $amount, $crypto = null)
    {
        $varb = $wallet . "?amount=" . $amount;
        return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8";
    }
}
