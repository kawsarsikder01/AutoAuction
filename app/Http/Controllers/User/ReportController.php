<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportConversation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Notify;

class ReportController extends Controller
{
    use Notify;
    public function index()
    {
        $reports = Report::with(['reporter'=>function($query){
            $query->select('id','firstname','lastname');
        },'repotedUser'=>function($query){
            $query->select('id','firstname','lastname');
        }])
        ->where(function ($query){
            $query->where('repoter_id',Auth::user()->id);
        })->orWhere(function ($query){
            $query->where('reported_user_id',Auth::user()->id);
    })->paginate(basicControl()->paginate);
        return view(template().'user.pages.reports',compact('reports'));
    }
    public function store(Request $request,$repoter_id,$repoted_id,$vehicle_id)
    {

        try {
            if (Auth::user()->id != $repoter_id){
                abort(403);
            }
            $request->validate([
                'subject' => 'required | string | max:50',
                'reason' => 'required | string | min:5 | max:300'
            ]);

            $report  = Report::where(function ($query)use($repoter_id,$repoted_id,$vehicle_id){
                $query->where('repoter_id',$repoter_id)
                    ->where('reported_user_id',$repoted_id)
                    ->where('vehicle_id',$vehicle_id);
            })
                ->orWhere(function ($query)use($vehicle_id,$repoter_id,$repoted_id){
                    $query->where('repoter_id',$repoted_id)
                        ->where('reported_user_id',$repoter_id)
                        ->where('vehicle_id',$vehicle_id);
                })->first();

            if ($report != null){
                abort(403);
            }
            $report = new Report();
            $report->repoter_id = $repoter_id;
            $report->reported_user_id = $repoted_id;
            $report->vehicle_id = $vehicle_id;
            $report->subject =  $request->subject;
            $report->reason =  $request->reason;
            $report->save();
            $msg = [
                "subject" => $request->subject,
                "reason" => $request->reason,
            ];
            $subject = "User Report";
            $action = [
                "link" => route('admin.user.report',$report->id),
                "icon" => "<i class='bi bi-bell-fill'></i>",
                "image" => getFile(Auth::user()->image_driver, Auth::user()->image)
            ];
            $this->adminPushNotification( 'REPORT_NOTIFICATION', $msg, $action);
            $this->adminFirebasePushNotification('REPORT_NOTIFICATION', $msg, route('admin.user.report',$report->id));
            $this->adminMail( 'REPORT_NOTIFICATION', $msg,$subject);
            $msg2 = [
                "reporter" => Auth::user()->firstname." ".Auth::user()->lastname ,
                "subject" => $request->subject,
                "reason" => $request->reason,
            ];
            $action2 = [
                "link" => route('user.get.conversation',$report->id),
                "icon" => "fas fa-money-bill-alt text-white",
            ];
            $this->userPushNotification($report->repotedUser,'REPORT_NOTIFICATION_USER',$msg2,$action2);
            $this->userFirebasePushNotification($report->repotedUser,'REPORT_NOTIFICATION_USER',$msg2,route('user.get.conversation',$report->id));
            $this->sendMailSms($report->repotedUser,'REPORT_NOTIFICATION_USER',$msg2);

            return back()->with('success','Your Report send Successfully');
        }catch (Exception $error){
            abort(403);;
        }
    }

    public function getConversation($id)
    {
        try {
            $report =  Report::findOrFail($id);
            $conversations = ReportConversation::where('report_id',$id)->get();

            if ( $report && ( $report->repoter_id != Auth::user()->id && $report->reported_user_id != Auth::user()->id)){
               throw new Exception('Report Not Found');
            }
            return view(template().'user.pages.reportConversation',compact('report','conversations'));
        }catch (Exception $exception){
           abort(404);
        }

    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required | string'
        ]);
        try {
            $report = Report::findOrFail($request->report_id);
            $conversation = new ReportConversation();
            $conversation->sender_id = Auth::user()->id;
            $conversation->reporter_id = $report->repoter_id;
            $conversation->reported_id = $report->reported_user_id;
            $conversation->report_id = $report->id;
            $conversation->admin_id = null;
            $conversation->message = $request->message;
            $conversation->save();
            return back();
        } catch (\Exception $exception) {
            abort(404);
        }
    }
}
