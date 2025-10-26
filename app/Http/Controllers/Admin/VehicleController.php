<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Traits\Notify;
use App\Traits\Upload;


class VehicleController extends Controller
{
    use Notify,Upload;
    public function pendingVehicle()
    {
        return view('admin.vehicleRequest.pendingVehicle');
    }

    public function pendingVehicleSearch(Request $request)
    {
        $vehichle = Vehicle::query()->with('details:id,vehicle_id,title','user:id,firstname,lastname,username,image,image_driver')
                    ->where('status',0)
                    ->when(!empty($request->search['value']),function ($query)use($request){
                        $query->whereHas('details',function ($q)use($request){
                            $q->where('title','LIKE','%'.$request->search['value'].'%')
                            ->orWhere('vehicle_type','LIKE','%'.$request->search['value'].'%')
                            ->orWhere('engine_type','LIKE','%'.$request->search['value'].'%')
                            ->orWhere('price',$request->search['value']);
                        })
                            ->orWhereHas('user',function ($q)use($request){
                                $q->where('firstname','LIKE','%'.$request->search['value'].'%')
                                    ->orWhere('lastname','LIKE','%'.$request->search['value'].'%')
                                    ->orWhere('username','LIKE','%'.$request->search['value'].'%');
                            });

                    })
            ->orderByDesc('created_at');

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
                return currencyPosition($item->details->price);
            })
            ->addColumn('action', function ($item) {
                $viewUrl = route('auction.details',[slug($item->details->title)??'',$item->id]);
                return "<div class='btn-group' role='group'>
                      <a href ='$viewUrl' class='btn btn-white btn-sm edit_user_btn'>
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
       try {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = 1;
        $vehicle->update();
        return back()->with('success','Vehicle Approved Successfully');
       } catch (\Exception $exception) {
        abort(404);
       }
    }


    public function approvedVehicle()
    {
        return view('admin.vehicleRequest.approvedVehicle');
    }
    public function getApprovedVehicle(Request $request)
    {
        $vehichle = Vehicle::query()->with('details:id,vehicle_id,title','user:id,firstname,lastname,username,image,image_driver')
                                ->where('status',1)
                                ->when(!empty($request->search['value']),function ($query)use($request){
                                    $query->whereHas('details',function ($q)use($request){
                                        $q->where('title','LIKE','%'.$request->search['value'].'%');
                                    })
                                    ->orWhereHas('user',function ($q)use($request){
                                        $q->where('firstname','LIKE','%'.$request->search['value'].'%')
                                        ->orWhere('lastname','LIKE','%'.$request->search['value'].'%')
                                        ->orWhere('username','LIKE','%'.$request->search['value'].'%');
                                    });

                                })
        ->orderByDesc('created_at');
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
                return $item->biddingHistory->max('bid_amount')? currencyPosition($item->biddingHistory->max('bid_amount')): currencyPosition(0) ;
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
      try {
        $vehicle = Vehicle::with('details')->findOrFail($id);
         if ($vehicle){
             $vehicle->update([
                 'status' => 2
             ]);
             $vehicle->details->update([
                 'rejected_reason' => $request->rejected_reason
             ]);
         }
         return  back()->with('success','Vehicle Rejected Successfully');
      } catch (\Exception $exception) {
        abort(404);
      }
    }

    public function getRejectedList(Request $request)
    {
        $vehichle = Vehicle::query()->with('details:id,vehicle_id,title','user:id,firstname,lastname,username,image,image_driver')
            ->where('status',2)
            ->when(!empty($request->search['value']),function ($query)use($request){
                $query->whereHas('details',function ($q)use($request){
                    $q->where('title','LIKE','%'.$request->search['value'].'%')
                        ->orWhere('vehicle_type','LIKE','%'.$request->search['value'].'%')
                        ->orWhere('engine_type','LIKE','%'.$request->search['value'].'%')
                        ->orWhere('price',$request->search['value']);
                })
                    ->orWhereHas('user',function ($q)use($request){
                        $q->where('firstname','LIKE','%'.$request->search['value'].'%')
                            ->orWhere('lastname','LIKE','%'.$request->search['value'].'%')
                            ->orWhere('username','LIKE','%'.$request->search['value'].'%');
                    });

            })
        ->orderByDesc('created_at');

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
                return currencyPosition($item->details->price);
            })
            ->addColumn('action', function ($item) {
                $viewUrl = route('auction.details',[slug($item->details->title)??'',$item->id]);
                return "<div class='btn-group' role='group'>
                      <a href='$viewUrl' class='btn btn-white btn-sm edit_user_btn'>
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
    public function getBiddingHistory(Request $request , $id)
    {

        $biddingHistory= BiddingHistory::with('bidder:id,firstname,lastname,username,image,image_driver')
                        ->when(!empty($request->search['value']) , function ($query)use($request){
                            $query->where('bid_amount',$request->search['value'])
                                    ->orWhereHas('bidder',function ($q)use($request){
                                        $q->where('firstname','LIKE','%'.$request->search['value'].'%')
                                            ->orWhere('lastname','LIKE','%'.$request->search['value'].'%')
                                            ->orWhere('username','LIKE','%'.$request->search['value'].'%');
                                    });
                        })
                      ->where('vehicle_id',$id);
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
        try {
            $bid = BiddingHistory::findOrFail($id);
            if($bid->wining_status == 1){
                return back()->with('warning','You Can Not Delete This Bid');
            }
            $bid->delete();
            return back()->with('success',"Bid Delete Successfully");
        }catch (\Exception $exception){
            abort(404);
        }
    }
    public function destroy(Request $request)
    {
        try {
            $vehicle = Vehicle::findOrFail($request->id);
            $vehicle->reports()->delete();
            if (!$vehicle->biddingHistory->first()) {
                $vehicle->user->total_listed_car = $vehicle->user->total_listed_car - 1;
                $vehicle->user->update();
            }
            $vehicle->biddingHistory()->delete();

            if($request->reason){
                $msg = [
                    'name' => $vehicle->user->firstname.$vehicle->user->lastname,
                    'vehicle_model' => $vehicle->details->title,
                    'reason'  => $request->reason,

                ];
                $action = [
                    "link" => route('user.listed.vehicle'),
                    "icon" => "fas fa-money-bill-alt text-white"
                ];
                $this->userPushNotification($vehicle->user, 'DELETE_VEHICLE', $msg, $action);
                $this->userFirebasePushNotification($vehicle->user,'DELETE_VEHICLE', $msg, route('user.listed.vehicle'));
                $this->sendMailSms($vehicle->user, 'DELETE_VEHICLE',$msg);
            }
            $vehicle->reacts()->delete();
            $vehicle->details->delete();
            foreach ($vehicle->path_name as $path){
                $this->fileDelete($vehicle->driver,$path);
            }
            foreach ( $vehicle->reports as $report){
                $report->conversation()->delete();
            }
            $vehicle->reports()->delete();
            $vehicle->delete();
            return redirect()->route('auction')->with('success','Vehicle Delete Successfully');
        }catch (\Exception $exception){
            abort(404);
        }
    }
}
