<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.Reports.reports');
    }
    public function getReports()
    {
        $reports = Report::get();
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
        $report  = Report::findOrFail($id);
        $report->delete();
        return back()->with('success','Report Deleted Successfully');
    }
    public function viewReport($id)
    {
        $report  = Report::findOrFail($id);
        $conversations = ReportConversation::where('reporter_id',$report->repoter_id)
            ->where('reported_id',$report->reported_user_id )
            ->where('report_id',$report->id)->get();
        return view('admin.Reports.view',compact('report','conversations'));
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
}
