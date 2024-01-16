<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Traits\Notify;


class VehicleController extends Controller
{
    use Notify;
    public function pendingVehicle()
    {
        return view('admin.vehicleRequest.pendingVehicle');
    }

    public function pendingVehicleSearch(Request $request)
    {
        $vehichle = Vehicle::where('status',0)->with('details','user')->get();

        return DataTables::of($vehichle)
            ->addColumn('no', function ($item) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('seller', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$item->user_id ).'">
                <div class="flex-shrink-0">
                    '.optional($item->user)->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($item->user)->firstname . ' ' . optional($item->user)->lastname . '</h5>
                  <span class="fs-6 text-body">@' . optional($item->user)->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('title', function ($item) {
                return $item->details->title;
            })
            ->addColumn('vehicle_type', function ($item) {

                return $item->details->vehicle_type;
            })
            ->addColumn('engine_type', function ($item) {
                return $item->details->engine_type;
            })
            ->addColumn('price', function ($item) {
                return $item->details->price;
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('admin.user.edit', $item->id);
                $viewProfile = route('admin.user.view.profile', $item->id);
                return "<div class='btn-group' role='group'>
                      <a href' class='btn btn-white btn-sm edit_user_btn'>
                        <i class='bi-eye-fill dropdown-item-icon'></i> ".trans('View')."
                      </a>
                    <div class='btn-group'>
                      <button type='button' class='btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty' id='userEditDropdown' data-bs-toggle='dropdown' aria-expanded='false'></button>
                      <div class='dropdown-menu dropdown-menu-end mt-1' aria-labelledby='userEditDropdown'>
                          <a class='dropdown-item loginAccount' href='javascript:void(0)'
                           data-bs-toggle='modal' data-bs-target='#vehicleApproved'>
                            <i class='bi bi-check dropdown-item-icon'></i>
                          ".trans("Approved")."
                        </a>
                        <a class='dropdown-item loginAccount' href='javascript:void(0)'
                           data-bs-toggle='modal' data-bs-target='#vehicleReject'>
                            <i class='bi bi-check dropdown-item-icon'></i>
                          ".trans("Reject")."
                        </a>

                      </div>
                    </div>
                  </div>
                  <div class='modal fade bd-example-modal-sm' id = 'vehicleApproved' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-sm' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h5 class='modal-title h4' id='mySmallModalLabel'>Confirmation</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <form action=".route('admin.vehicle.status.update',$item->id)." method='get'>
                            <div class='modal-body'>
                                <p class='message'>Do you want to approved this Vehicle??</p>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-white' data-bs-dismiss='modal'>".trans('Close')."</button>
                                <button type='submit' class='btn btn-primary'>".trans('Confirm')."</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
                <div class='modal fade bd-example-modal-sm' id = 'vehicleReject' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-sm' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h5 class='modal-title h4' id='mySmallModalLabel'>Confirmation</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <form action=".route('admin.vehicle.reject',$item->id)." method='get'>
                            <div class='modal-body'>
                                <p class='message'>Do you want to rejected this Vehicle?</p>
                                <span class='mb-1'>".trans('Rejection Reason')."</span>
                                <textarea class ='form-control' name='rejected_reason'></textarea>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-white' data-bs-dismiss='modal'>".trans('Close')."</button>
                                <button type='submit' class='btn btn-primary'>".trans('Confirm')."</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>

                  ";
            })->rawColumns(['no', 'seller', 'title','vehicle_type','engine_type','price','action'])
            ->make(true);
    }

    public function statusUpdate($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = 1;
        $vehicle->update();
        return back()->with('success','Vehicle Approved Successfully');
    }


    public function approvedVehicle()
    {
        return view('admin.vehicleRequest.approvedVehicle');
    }
    public function getApprovedVehicle()
    {
        $vehichle = Vehicle::where('status',1)->with('details','user')->get();

        return DataTables::of($vehichle)
            ->addColumn('no', function ($item) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('seller', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$item->user_id ).'">
                <div class="flex-shrink-0">
                    '.optional($item->user)->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($item->user)->firstname . ' ' . optional($item->user)->lastname . '</h5>
                  <span class="fs-6 text-body">@' . optional($item->user)->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('title', function ($item) {
                return $item->details->title;
            })
            ->addColumn('total_bid', function ($item) {

                return count($item->biddingHistory);
            })
            ->addColumn('max_bid', function ($item) {
                return $item->biddingHistory->max('bid_amount')? $item->biddingHistory->max('bid_amount') ." ".basicControl()->currency_symbol:0 ." ".basicControl()->currency_symbol;
            })
            ->addColumn('status', function ($item) {
                $status = $item->details->sold_status == 1 ? 'Sold' : 'Unsold';
                $bg = $item->details->sold_status == 1 ? 'success' : 'danger';
                return "<span class='badge  bg-soft-success text-$bg bg-soft-$bg text-$bg'><span class='legend-indicator bg-$bg'></span>".$status."</span>";
            })
            ->addColumn('action', function ($item) {
                $viewUrl = route('auction.details',[slug($item->details->title)??'',$item->id]);
                $biddingHistoryUrl = route('admin.view.vehicle.biddingHistory', $item->id);
                return "<div class='btn-group' role='group'>
                      <a href='$viewUrl' class='btn btn-white btn-sm edit_user_btn'>
                        <i class='bi-eye-fill dropdown-item-icon'></i> ".trans('View')."
                      </a>
                    <div class='btn-group'>
                      <button type='button' class='btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty' id='userEditDropdown' data-bs-toggle='dropdown' aria-expanded='false'></button>
                      <div class='dropdown-menu dropdown-menu-end mt-1' aria-labelledby='userEditDropdown'>
                          <a class='dropdown-item loginAccount' href='$biddingHistoryUrl'>
                            <i class='bi bi-collection'></i>
                          ".trans("Bidding History")."
                        </a>
                      </div>
                    </div>
                  </div>";
            })->rawColumns(['no','seller','title','total_bid','max_bid','status','action',])
            ->make(true);
    }
    public  function RejectedVehicleList()
    {
        return view('admin.vehicleRequest.rejected');
    }

    public function vehicleReject(Request $request,$id)
    {
       $validator = Validator::make($request->all(),['rejected_reason' => 'required|string']);
       if ($validator->fails()){
           return back()->with('error','Rejected reason is required');
       }
       $vehicle = Vehicle::with('details')->find($id);
        if ($vehicle){
            $vehicle->update([
                'status' => 2
            ]);
            $vehicle->details->update([
                'rejected_reason' => $request->rejected_reason
            ]);
        }
        return  back()->with('success','Vehicle Rejected Successfully');
    }

    public function getRejectedList()
    {
        $vehichle = Vehicle::where('status',2)->with('details','user')->get();

        return DataTables::of($vehichle)
            ->addColumn('no', function ($item) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('seller', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$item->user_id ).'">
                <div class="flex-shrink-0">
                    '.optional($item->user)->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($item->user)->firstname . ' ' . optional($item->user)->lastname . '</h5>
                  <span class="fs-6 text-body">@' . optional($item->user)->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('title', function ($item) {
                return $item->details->title;
            })
            ->addColumn('vehicle_type', function ($item) {

                return $item->details->vehicle_type;
            })
            ->addColumn('engine_type', function ($item) {
                return $item->details->engine_type;
            })
            ->addColumn('price', function ($item) {
                return $item->details->price;
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('admin.user.edit', $item->id);
                $viewProfile = route('admin.user.view.profile', $item->id);
                return "<div class='btn-group' role='group'>
                      <a href' class='btn btn-white btn-sm edit_user_btn'>
                        <i class='bi-eye-fill dropdown-item-icon'></i> ".trans('View')."
                      </a>
                  </div>
                  ";
            })->rawColumns(['no', 'seller', 'title','vehicle_type','engine_type','price','action'])
            ->make(true);
    }
    public function viewBiddingHistory($id)
    {
        return view('admin.vehicleBiddingHistory.viewBiddingHistory',compact('id'));

    }
    public function getBiddingHistory($id)
    {
        $vehicle = Vehicle::with('biddingHistory')->find($id);
        $biddingHistory = $vehicle->biddingHistory;
        return DataTables::of($biddingHistory)
            ->addColumn('no', function ($item) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('bidder',function ($item){
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$item->user_id ).'">
                <div class="flex-shrink-0">
                    '.optional($item->bidder)->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . optional($item->bidder)->firstname . ' ' . optional($item->bidder)->lastname . '</h5>
                  <span class="fs-6 text-body">@' . optional($item->bidder)->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('bidAmount',function ($item){
                return number_format($item->bid_amount,2,'.',',');
            })
            ->addColumn('win_status',function ($item){
                if ($item->vehicle->details->sold_status == 1){
                    if ($item->vehicle->biddingHistory->max('bid_amount') == $item->bid_amount){
                        $status =   'Win';
                    }else{
                        $status = 'Not Win';
                    }
                }else{
                    $status = 'Unsold';
                }

                $bg = $item->vehicle->details->sold_status == 1 ? 'success' : 'danger';
                return "<span class='badge  bg-soft-success text-$bg bg-soft-$bg text-$bg'><span class='legend-indicator bg-$bg'></span>".$status."</span>";
            })
            ->addColumn('action',function ($item){
                return "<div class='btn-group' role='group'>
                      <a href = ".route('admin.delete.history',$item->id)." class='btn btn-white btn-sm edit_user_btn'>
                        <i class='bi bi-trash'></i> ".trans('Delete')."
                      </a>
                  </div>
                  ";
            })->rawColumns(['no', 'bidder', 'bidAmount','win_status','action'])
            ->make(true);

    }
    public function deleteHistory($id)
    {
        $bid = BiddingHistory::find($id);
        if($bid->wining_status == 1){
            return back()->with('warning','You Can Not Delete This Bid');
        }
        $bid->delete();
        return back()->with('success',"Bid Delete Successfully");
    }
    public function destroy(Request $request)
    {
        $vehicle = Vehicle::find($request->id);
       foreach($vehicle->biddingHistory as $item){
        $item->delete();
       }
        $vehicle->details->delete();
        foreach ($vehicle->path_name as $path){
            $this->fileDelete($vehicle->driver,$path);
        }
        $vehicle->delete();
       return redirect()->route('auction')->with('success','Vehicle Delete Successfully');
    }
}
