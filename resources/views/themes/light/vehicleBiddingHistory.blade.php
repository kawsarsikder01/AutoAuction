@extends($theme.'layouts.user')
@section('title',trans('Vehicle Bidding History'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">Vehicle Bidding History</h4>
          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <div class="table-search-bar">
                <div class="d-none d-lg-block">
                   <form>
                      <div class="row g-3 align-items-end">
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <input type="text" class="form-control" placeholder="Search" />
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <button class="btn-custom w-100"><i class="fal fa-search"></i> Filter</button>
                         </div>
                      </div>
                   </form>
                </div>
                <div class="d-lg-none justify-content-end">
                   <button
                      type="button"
                      class="btn-action"
                      data-bs-toggle="modal"
                      data-bs-target="#editModal"
                   >
                      Filter <i class="fa-light fa-filter"></i>
                   </button>
                </div>
             </div>
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">Bidder</th>
                      <th scope="col">Title</th>
                      <th scope="col">Bid Amount</th>
                      <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($historys as $key => $biddingHistory)
                    <tr>
                        <td data-label="@lang('Bidder')">
                            <a class="d-flex align-items-center me-2" href="">
                                <div class="flex-shrink-0">
                                  <div class="avatar avatar-sm avatar-circle">
                                    <img id="avaterImg"  src="{{getFile($biddingHistory->bidder->image_driver,$biddingHistory->bidder->image)}}" alt="Image Description">
                                    <span class="avatar-status avatar-sm-status avatar-status-warning"></span>
                                </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h6 class="text-hover-primary mb-0">{{$biddingHistory->bidder->firstname." ".$biddingHistory->bidder->lastname}}</h6>
                                  <span class="fs-6 text-body">{{$biddingHistory->bidder->username}}</span>
                                </div>
                              </a>
                        </td>
                        <td data-label="@lang('Title')">
                                {{$biddingHistory->vehicle->details->title}}
                        </td>
                       
                        <td data-label="@lang('Bid Amount')">
                          {{$biddingHistory->bid_amount}}
                        </td>
                        <td data-label="@lang('Action')">
                            <div>
                              @if ($biddingHistory->wining_status == 0 )
                            
                              <a href="" onclick="event.preventDefault(); document.getElementById('deleteBid{{$key}}').submit();" class="btn-action-icon bg-primary">
                                 <i class="fa-solid fa-trash"></i>
                               </a>
                               <form id="deleteBid{{$key}}" action="{{route('user.delete.vehicle.bidding.history')}}" method="POST" class="d-none">
                                 @csrf
                                 <input type="hidden" value="{{$biddingHistory->id}}" name="bid_id">
                              </form>
                              @endif
                              @if ($biddingHistory->wining_status == 1)
                              <a href="" class="btn-action-icon bg-primary" id="report" data-route="{{route('user.store.report',[$biddingHistory->vehicle->user_id??0,$biddingHistory->user_id])}}" data-bs-toggle="modal" data-bs-target="#ReportModal">
                                 <i class="fal fa-flag-alt" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report"></i>
                               </a>
                               <a href="" class="btn-action-icon bg-warning">
                                 <i class="fa-brands fa-rocketchat"></i>
                             </a>
                              @endif
                            </div>
                         </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td>{{__('No Data Found!')}}</td>
                    </tr>
                @endforelse
                </tbody>
             </table>

             <!-- pagination -->
             <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end mt-4">
                    {{-- {{ $tickets->appends($_GET)->links($theme.'partials.pagination') }} --}}
                </ul>
             </nav>
          </div>
       </div>
    </div>
 </div>
<!-- Modal -->
<div class="modal fade"  id="ReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h1 class="modal-title text-black fs-5" id="staticBackdropLabel">Report</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <form action="" id="FormRoute" method="POST">
              @csrf
               <div class="modal-body">
                   <div class="row justify-content-center align-items-center">
                       <div class="col-lg-12">
                          <div class="form-wrapper">
                                <div class="row g-4">
                                   <div class="form-group mb-2">
                                       <label>@lang('Subject')</label>
                                       <input class="form-control" type="text" name="subject"
                                               placeholder="@lang('Enter Subject')">
                                   </div>
                                   @error("subject")
                                   <span class="invalid-feedback d-block" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                 @enderror
                                   <div class="form-group mb-2">
                                       <label>@lang('Reason')</label>
                                       <textarea class="form-control ticket-box" name="reason" rows="5"
                                                 id="textarea1"
                                                 placeholder="@lang('Enter Reason')">{{old('message')}}</textarea>
                                   </div>
                                   @error("reason")
                                   <span class="invalid-feedback d-block" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                 @enderror
                                </div>
                          </div>
                       </div>
                    </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="btn-custom">Confirm</button>
               </div>
           </form>
       </div>
   </div>
</div>
@endsection
@push('script')
   <script>
      $(document).ready(function(){
         $('#FormRoute').attr('action', $('#report').data('route'));
        })
   </script>
@endpush
<input type="text">