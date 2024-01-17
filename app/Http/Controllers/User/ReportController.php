<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportConversation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where(function ($query){
            $query->where('repoter_id',Auth::user()->id);
        })->orWhere(function ($query){
            $query->where('reported_user_id',Auth::user()->id);
    })->get();
        return view(template().'reports',compact('reports'));
    }
    public function store(Request $request,$repoter_id,$repoted_id,$vehicle_id)
    {
    if (Auth::user()->id != $repoter_id){
        return abort(404);
    }
        $request->validate([
            'subject' => 'required | string | max:50',
            'reason' => 'required | string | min:5 | max:300'
        ]);
        try {
            $report = new Report();
            $report->repoter_id = $repoter_id;
            $report->reported_user_id = $repoted_id;
            $report->vehicle_id = $vehicle_id;
            $report->subject =  $request->subject;
            $report->reason =  $request->reason;
            $report->save();
            return back()->with('success','Your Report send Successfully');
        }catch (Exception $error){
            return back()->with('error', $error->getMessage());
        }
    }

    public function getConversation($id)
    {
        $report =  Report::find($id);
        $conversations = ReportConversation::where('report_id',$id)->get();
        return view(template().'reportConversation',compact('report','conversations'));
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required | string'
        ]);
        $conversation = new ReportConversation();
        $conversation->sender_id = Auth::user()->id;
        $conversation->reporter_id = $request->reporter_id;
        $conversation->reported_id = $request->repotedUser_id;
        $conversation->report_id = $request->report_id;
        $conversation->admin_id = null;
        $conversation->message = $request->message;
        $conversation->save();
        return back();
    }
}
