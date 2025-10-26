<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Deposit;
use App\Models\Payout;
use App\Models\PlanPurchaseHistory;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserKyc;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;


class DashboardController extends Controller
{
    use Upload, Notify;
    public function index()
    {
        $data['firebaseNotify'] = config('firebase');
        $data['latestUser'] = User::latest()->limit(5)->get();
        $statistics['schedule'] = $this->dayList();
        return view('admin.dashboard-alternative', $data, compact("statistics",));
    }

    public function chartUserRecords()
{
    $currentMonth = Carbon::now()->format('Y-m');
    $userRecord = collect(User::selectRaw('COUNT(id) AS totalUsers')
        ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateUserCount')
        ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateUserCount')
        ->get()->makeHidden(['last-seen-activity', 'fullname'])
        ->toArray())->collapse();
    $followupGrap = $this->followupGrap($userRecord['currentDateUserCount'], $userRecord['previousDateUserCount']);

    $userRecord->put('followupGrapClass', $followupGrap['class']);
    $userRecord->put('followupGrap', $followupGrap['percentage']);

    $current_month_data = DB::table('users')
        ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
        ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
        ->orderBy('created_at', 'asc')
        ->groupBy('date')
        ->get();

    $current_month_data_dates = $current_month_data->pluck('date');
    $current_month_datas = $current_month_data->pluck('count');
    $userRecord['chartPercentageIncDec'] = fractionNumber($userRecord['totalUsers'] - $userRecord['currentDateUserCount'], false);
    return response()->json(['userRecord' => $userRecord, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
}
    public function chartTicketRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $ticketRecord = collect(SupportTicket::selectRaw('COUNT(id) AS totalTickets')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateTicketsCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateTicketsCount')
            ->selectRaw('count(CASE WHEN status = 2  THEN status END) AS replied')
            ->selectRaw('count(CASE WHEN status = 1  THEN status END) AS answered')
            ->selectRaw('count(CASE WHEN status = 0  THEN status END) AS pending')
            ->get()
            ->toArray())->collapse();

        $followupGrap = $this->followupGrap($ticketRecord['currentDateTicketsCount'], $ticketRecord['previousDateTicketsCount']);
        $ticketRecord->put('followupGrapClass', $followupGrap['class']);
        $ticketRecord->put('followupGrap', $followupGrap['percentage']);

        $current_month_data = DB::table('support_tickets')
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $ticketRecord['chartPercentageIncDec'] = fractionNumber($ticketRecord['totalTickets'] - $ticketRecord['currentDateTicketsCount'], false);
        return response()->json(['ticketRecord' => $ticketRecord, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }
    public function chartKycRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $kycRecords = collect(UserKyc::selectRaw('COUNT(id) AS totalKYC')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateKYCCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateKYCCount')
            ->selectRaw('count(CASE WHEN status = 0  THEN status END) AS pendingKYC')
            ->get()
            ->toArray())->collapse();
        $followupGrap = $this->followupGrap($kycRecords['currentDateKYCCount'], $kycRecords['previousDateKYCCount']);
        $kycRecords->put('followupGrapClass', $followupGrap['class']);
        $kycRecords->put('followupGrap', $followupGrap['percentage']);


        $current_month_data = DB::table('user_kycs')
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $kycRecords['chartPercentageIncDec'] = fractionNumber($kycRecords['totalKYC'] - $kycRecords['currentDateKYCCount'], false);
        return response()->json(['kycRecord' => $kycRecords, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }
    public function chartTransactionRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');

        $transaction = collect(Transaction::selectRaw('COUNT(id) AS totalTransaction')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateTransactionCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateTransactionCount')
            ->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')
            ->get()
            ->toArray())
            ->collapse();

        $followupGrap = $this->followupGrap($transaction['currentDateTransactionCount'], $transaction['previousDateTransactionCount']);
        $transaction->put('followupGrapClass', $followupGrap['class']);
        $transaction->put('followupGrap', $followupGrap['percentage']);


        $current_month_data = DB::table('transactions')
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $transaction['chartPercentageIncDec'] = fractionNumber($transaction['totalTransaction'] - $transaction['currentDateTransactionCount'], false);
        return response()->json(['transactionRecord' => $transaction, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }
    public function chartLoginHistory()
    {
        $userLoginsData = DB::table('user_logins')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->select('browser', 'os', 'get_device')
            ->get();

        $userLoginsBrowserData = $userLoginsData->groupBy('browser')->map->count();
        $data['browserKeys'] = $userLoginsBrowserData->keys();
        $data['browserValue'] = $userLoginsBrowserData->values();

        $userLoginsOSData = $userLoginsData->groupBy('os')->map->count();
        $data['osKeys'] = $userLoginsOSData->keys();
        $data['osValue'] = $userLoginsOSData->values();

        $userLoginsDeviceData = $userLoginsData->groupBy('get_device')->map->count();
        $data['deviceKeys'] = $userLoginsDeviceData->keys();
        $data['deviceValue'] = $userLoginsDeviceData->values();

        return response()->json(['loginPerformance' => $data]);
    }
    public function monthlyDepositWithdraw(Request $request)
    {
        $keyDataset = $request->keyDataset;

        $dailyDeposit = $this->dayList();

        Deposit::when($keyDataset == '0', function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        })
            ->when($keyDataset == '1', function ($query) {
                $lastMonth = Carbon::now()->subMonth();
                $query->whereMonth('created_at', $lastMonth->month);
            })
            ->select(
                DB::raw('SUM(payable_amount_in_base_currency) as totalDeposit'),
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyDeposit) {
                $dailyDeposit->put($item['date'], $item['totalDeposit']);
            });

        return response()->json([
            "totalDeposit" => currencyPosition($dailyDeposit->sum()),
            "dailyDeposit" => $dailyDeposit,
        ]);
    }

    public function dayList()
    {
        $totalDays = Carbon::now()->endOfMonth()->format('d');
        $daysByMonth = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            array_push($daysByMonth, ['Day ' . sprintf("%02d", $i) => 0]);
        }

        return collect($daysByMonth)->collapse();
    }

    public function saveToken(Request $request)
    {
        $admin = Auth::guard('admin')->user()
            ->fireBaseToken()
            ->create([
                'token' => $request->token,
            ]);
        return response()->json([
            'msg' => 'token saved successfully.',
        ]);
    }




    protected function followupGrap($todaysRocords, $lasDayRocords = 0)
    {

        if (0 < $lasDayRocords) {
            $percentageIncrease = (($todaysRocords - $lasDayRocords) / $lasDayRocords) * 100;
        } else {
            $percentageIncrease = 0;
        }
        if ($percentageIncrease > 0) {
            $class = "bg-soft-success text-success";
        } elseif ($percentageIncrease < 0) {
            $class = "bg-soft-danger text-danger";
        } else {
            $class =  "bg-soft-secondary text-body";
        }

        return [
            'class' => $class,
            'percentage' => round($percentageIncrease, 2)
        ];
    }
    public function hourList()
    {
        $hoursByDay = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $formattedHour = sprintf('%02d:00 %s', $hour, $hour < 12 ? 'AM' : 'PM');
            $hoursByDay[$formattedHour] = '00';
        }

        return $hoursByDay;
    }
    public function planPurchaseHistory()
    {
        $hourlyPurchaseHistory = $this->hourList();
        $labels = $this->hourList();
        $purchaseHistory =  PlanPurchaseHistory::whereDate('created_at', Carbon::today())
            ->select(
                DB::raw('SUM(price) as totalPurchase'),
                DB::raw('DATE_FORMAT(created_at, "%H:00 %p") as hourOfDay')
            )
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();
        foreach ($purchaseHistory as $item){

            $hourlyPurchaseHistory[$item['hourOfDay']] =  $item['totalPurchase'];
        }
        $hourlyPurchaseHistoryYesterday = $this->hourList();
        $purchaseHistoryYesterday = PlanPurchaseHistory::whereDate('created_at', Carbon::yesterday())
            ->select(
                DB::raw('SUM(price) as totalPurchase'),
                DB::raw('DATE_FORMAT(created_at, "%H:00 %p") as hourOfDay')
            )
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();

        foreach ($purchaseHistoryYesterday as $item){
            $hourlyPurchaseHistoryYesterday[$item['hourOfDay']] =  $item['totalPurchase'];
        }

        $totalPurchase = PlanPurchaseHistory::get()->sum('price');

        return response()->json([
            'hourlyPurchaseHistory' =>array_values($hourlyPurchaseHistory),
            'hourlyPurchaseHistoryYesterday' =>array_values($hourlyPurchaseHistoryYesterday),
            'labels' => array_keys($labels),
            'toDayPurchaseAmount' => currencyPosition($purchaseHistory->sum('totalPurchase')),
            'totalPurchaseAmount' => currencyPosition($totalPurchase)
        ]);
    }

    public function getVisitors()
    {
        $hourlyVisitors = $this->hourList();
        $labels = $this->hourList();
        $todayVisitors = Visitor::whereDate('created_at', Carbon::today())
            ->select(
                DB::raw('COUNT(id) as perHourVisitors'),
                DB::raw('DATE_FORMAT(created_at, "%H:00 %p") as hourOfDay')
            )
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();
        foreach ($todayVisitors as $item){
            $hourlyVisitors[$item['hourOfDay']] =  $item['perHourVisitors'];
        }
        $perHourYesterdayVisitors = $this->hourList();
        $YesterdayVisitors = Visitor::whereDate('created_at', Carbon::yesterday())
            ->select(
                DB::raw('COUNT(id) as perHourVisitors'),
                DB::raw('DATE_FORMAT(created_at, "%H:00 %p") as hourOfDay')
            )
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();

        foreach ($YesterdayVisitors as $item){
            $perHourYesterdayVisitors[$item['hourOfDay']] =  $item['perHourVisitors'];
        }
        $totalVisitors = Visitor::select(
            DB::raw('COUNT(id) as numberOfVisitors'),
        )->first();
        return response()->json([
            'perHourVisitors' => array_values($hourlyVisitors),
            'labels' => array_keys($labels),
            'perHourYesterdayVisitors' => array_values($perHourYesterdayVisitors),
            'totalVisitors' => $totalVisitors['numberOfVisitors'],
            'todayVisitors' => $todayVisitors->sum('perHourVisitors')
        ]);
    }
    public function getBidHistory()
    {
        $hourlyBid = $this->hourList();
        $labels = $this->hourList();
        $todayBid = BiddingHistory::whereDate('created_at', Carbon::today())
            ->select(
                DB::raw('SUM(bid_amount) as perHourBidAmount'),
                DB::raw('DATE_FORMAT(created_at, "%H:00 %p") as hourOfDay')
            )
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();
        foreach ($todayBid as $item){
            $hourlyBid[$item['hourOfDay']] =  $item['perHourBidAmount'];
        }
        $yesterdayHourlyBid = $this->hourList();
        $yesterdayBid = BiddingHistory::whereDate('created_at', Carbon::yesterday())
            ->select(
                DB::raw('SUM(bid_amount) as perHourBidAmount'),
                DB::raw('DATE_FORMAT(created_at, "%H:00 %p") as hourOfDay')
            )
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();
        foreach ($yesterdayBid as $item){
            $yesterdayHourlyBid[$item['hourOfDay']] =  $item['perHourBidAmount'];
        }

        $totalBid = BiddingHistory::select(
            DB::raw('SUM(bid_amount) as totalBidamount')
        )->first();
        return response()->json([
            'hourlyBid' => array_values($hourlyBid),
            'labels' => array_keys($labels),
            'yesterdayHourlyBid' => array_values($yesterdayHourlyBid),
            'totalBid' => currencyPosition($totalBid->totalBidamount),
            'todayTotalBid' => currencyPosition($todayBid->sum('perHourBidAmount'))
        ]);
    }

}
