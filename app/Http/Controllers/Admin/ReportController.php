<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Report;
use App\Models\ReportConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Exception;
use App\Traits\Notify;
class ReportController extends Controller
{
    use Notify;
    public function index()
    {
        return view('admin.Reports.reports');
    }
    public function getReports()
    {
        $reports = Report::orderBy('created_at','desc')->get();
        return DataTables::of($reports)
            ->addColumn('no',function ($report){
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('reporter',function ($report){
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$report->reporter->id ).'">
                <div class="flex-shrink-0">
                    '.optional($report->reporter)->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($report->reporter)->firstname . ' ' . optional($report->reporter)->lastname . '</h5>
                  <span class="fs-6 text-body">@' . optional($report->reporter)->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('repoted_user',function ($report){
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$report->repotedUser->id ).'">
                <div class="flex-shrink-0">
                    '.optional($report->repotedUser)->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($report->repotedUser)->firstname . ' ' . optional($report->repotedUser)->lastname . '</h5>
                  <span class="fs-6 text-body">@' . optional($report->repotedUser)->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('subject',function ($report){
                return $report->subject;
            })
            ->addColumn('action',function ($report){
                $viewUrl = route('admin.user.report',$report->id);
                $deleteUrl = route('admin.delete.report',$report->id);
                return "<div class='btn-group' role='group'>
                      <a href='$viewUrl' class='btn btn-white btn-sm edit_user_btn'>
                        <i class='bi-eye-fill dropdown-item-icon'></i> ".trans('View')."
                      </a>
                    <div class='btn-group'>
                      <button type='button' class='btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty' id='userEditDropdown' data-bs-toggle='dropdown' aria-expanded='false'></button>
                      <div class='dropdown-menu dropdown-menu-end mt-1' aria-labelledby='userEditDropdown'>
                          <a class='dropdown-item loginAccount' href='$deleteUrl'>
                            <i class='bi bi-trash'></i>
                          ".trans("Delete")."
                        </a>
                      </div>
                    </div>
                  </div>";
            })
            ->rawColumns(['no','reporter','repoted_user','subject','action'])
            ->make(true);
    }
    public function destroy($id)
    {
        try {
            $report  = Report::findOrFail($id);
            $report->delete();
            return back()->with('success','Report Deleted Successfully');
        }catch (Exception $exception){
            return view(template().'errors.404');
        }
    }
    public function viewReport($id)
    {

        try {
            $report  = Report::findOrFail($id);
            $bid = BiddingHistory::with('bidder')->where('vehicle_id',$report->Vehicle->id)
                ->where('bid_amount',$report->Vehicle->biddingHistory->max('bid_amount'))->first();

            $conversations = ReportConversation::where('reporter_id',$report->repoter_id)
                ->where('reported_id',$report->reported_user_id )
                ->where('report_id',$report->id)->get();
            return view('admin.Reports.view',compact('report','conversations','bid'));
        }catch (Exception $exception){
            return view(template().'errors.404');
        }
    }
    public  function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required | string'
        ]);
        $conversation = new ReportConversation();
        $conversation->sender_id = Auth::user()->id;
        $conversation->reporter_id = $request->reporter_id;
        $conversation->reported_id = $request->repotedUser_id;
        $conversation->report_id = $request->report_id;
        $conversation->admin_id = Auth::user()->id;
        $conversation->message = $request->message;
        $conversation->save();
        return back();
    }

    public function releaseSellerPayment($id)
    {

        try {
            $report = Report::with('Vehicle')->findOrFail($id);
            if ($report->Vehicle->details->sold_status == 0){
                throw new Exception('not found');
            };

            $bid = BiddingHistory::with('bidder')->where('vehicle_id',$report->Vehicle->id)
                ->where('bid_amount',$report->Vehicle->biddingHistory->max('bid_amount'))->first();
            if($bid->bidder->id != $report->repoter_id && $bid->bidder->id != $report->reported_user_id){
                throw new Exception('not found');
            }
            $bid->bidder->hold_balance = $bid->bidder->hold_balance - $report->Vehicle->biddingHistory->max('bid_amount');
            $bid->bidder->update();
            $report->Vehicle->user->balance = $report->Vehicle->user->balance + $report->Vehicle->biddingHistory->max('bid_amount');
            $report->Vehicle->user->update();
            $bid->wining_status = 1;
            $bid->update();
            $report->Vehicle->payment_status = 1;
            $report->Vehicle->release_status = 1;
            $report->Vehicle->update();
            $msg = [
                'vehicle_model' => $report->Vehicle->details->title,
                'currency' => basicControl()->currency_symbol,
                'bidder'  => $bid->bidder->firstname." ".$bid->bidder->lastname,
                'amount' => $report->Vehicle->biddingHistory->max('bid_amount')
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($report->Vehicle->user, 'RELEASE_PAYMENT_SELLER_SELLER', $msg, $action);
            $this->userFirebasePushNotification($report->Vehicle->user,'RELEASE_PAYMENT_SELLER_SELLER', $msg, "#");
            $this->sendMailSms($report->Vehicle->user, 'RELEASE_PAYMENT_SELLER_SELLER',$msg);
            $msg2 = [
                'vehicle_model' => $report->Vehicle->details->title,
                'currency' => basicControl()->currency_symbol,
                'seller'  => $report->Vehicle->user->firstname." ".$report->Vehicle->user->lastname,
                'amount' => $report->Vehicle->biddingHistory->max('bid_amount')
            ];
            $action2 = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($bid->bidder, 'RELEASE_PAYMENT_SELLER_BIDDER', $msg2, $action2);
            $this->userFirebasePushNotification($bid->bidder,'RELEASE_PAYMENT_SELLER_BIDDER', $msg2, "#");
            $this->sendMailSms($bid->bidder, 'RELEASE_PAYMENT_SELLER_BIDDER',$msg2);
            return back()->with('success','Seller Payment Release Successfully');
        }catch (Exception $error){
            return view(template().'errors.404');
        }
    }
    public function releaseBidderPayment($id)
    {
        try {
            $report = Report::with('Vehicle')->findOrFail($id);
            if ($report->Vehicle->details->sold_status == 0){
                throw new Exception('not found');
            };

            $bid = BiddingHistory::with('bidder')->where('vehicle_id',$report->Vehicle->id)
                ->where('bid_amount',$report->Vehicle->biddingHistory->max('bid_amount'))->first();
            if($bid->bidder->id != $report->repoter_id && $bid->bidder->id != $report->reported_user_id){
                throw new Exception('not found');
            }
            $bid->bidder->hold_balance = $bid->bidder->hold_balance - $report->Vehicle->biddingHistory->max('bid_amount');
            $bid->bidder->balance = $bid->bidder->balance + $report->Vehicle->biddingHistory->max('bid_amount');
            $bid->bidder->update();
            $report->Vehicle->payment_status = 2;
            $report->Vehicle->release_status = 2;
            $report->Vehicle->update();
            $msg = [
                'vehicle_model' => $report->Vehicle->details->title,
                'currency' => basicControl()->currency_symbol,
                'seller'  => $report->Vehicle->user->firstname." ".$report->Vehicle->user->lastname,
                'amount' => $report->Vehicle->biddingHistory->max('bid_amount')
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($bid->bidder, 'RELEASE_HOLD_BALANCE', $msg, $action);
            $this->userFirebasePushNotification($bid->bidder,'RELEASE_HOLD_BALANCE', $msg, "#");
            $this->sendMailSms($bid->bidder, 'RELEASE_HOLD_BALANCE',$msg);

            $msg1 = [
                'vehicle_model' => $report->Vehicle->details->title,
                'bidder'  => $bid->bidder->firstname." ".$bid->bidder->lastname,

            ];
            $action1 = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($report->Vehicle->user, 'CANCEL_AUCTION', $msg1, $action1);
            $this->userFirebasePushNotification($report->Vehicle->user,'CANCEL_AUCTION', $msg1, "#");
            $this->sendMailSms($report->Vehicle->user, 'CANCEL_AUCTION',$msg1);
            return back()->with('success','Release Bidder Payment Successfully');
        }catch (Exception $error){
            return view(template().'errors.404');
        }

    }
}
