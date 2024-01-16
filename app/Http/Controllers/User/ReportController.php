<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request$request,$repoter_id,$repoted_id)
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
            $report->subject =  $request->subject;
            $report->reason =  $request->reason;
            $report->save();
            return back()->with('success','Your Report send Successfully');
        }catch (Exception $error){
            return back()->with('error', $error->getMessage());
        }
    }
}
