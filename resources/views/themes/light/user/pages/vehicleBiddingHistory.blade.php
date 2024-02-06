@extends($theme.'layouts.user')
@section('title',trans('Vehicle Bidding History'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">{{$vehicleTitle." "}}: Bidding History</h4>
          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">@lang('Bidder')</th>
                      <th scope="col">@lang('Bid Amount')</th>
                      <th scope="col">@lang('Date')</th>
                      <th scope="col">@lang('Action')</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($historys as $key => $biddingHistory)
                    <tr>
                        <td data-label="@lang('Bidder')">
                            <a class="d-flex align-items-center me-2" href="javascript:void(0);">
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
                        <td data-label="@lang('Bid Amount')">
                           {{currencyPosition($biddingHistory->bid_amount)}}
                         </td>
                        <td data-label="@lang('Date')">
                                {{dateTime($biddingHistory->created_at)}}
                        </td>
                        <td data-label="@lang('Action')">
                            <div>
                              @if ($biddingHistory->wining_status == 1)
                              @if($report == null)
                                <a href="" class="btn-action-icon bg-primary" id="report" data-route="{{route('user.store.report',[$biddingHistory->vehicle->user_id??0,$biddingHistory->user_id,$biddingHistory->vehicle->id])}}" data-bs-toggle="modal" data-bs-target="#ReportModal">
                                    <i class="fal fa-flag-alt" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report"></i>
                                </a>
                              @endif
                               <a href="{{route('user.messages',[$biddingHistory->user_id,$biddingHistory->id])}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Message" class="btn-action-icon bg-warning">
                                 <i class="fa-brands fa-rocketchat"></i>
                             </a>
                              @endif
                              <a href="{{ route('auction.details', [slug($biddingHistory->vehicle->details->title)??'',$biddingHistory->vehicle_id]) }}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="View" class="btn-action-icon bg-success">
                                 <i class="fad fa-eye"></i>
                             </a>
                            </div>
                         </td>
                    </tr>

                @endforeach
                </tbody>
             </table>
              @if (count($historys) == 0)
                  <div class="text-center p-4" >
                      <img  class="dataTables-image mb-3"
                            id="emptyImage"
                            src="{{ asset($themeTrue.'img/img/no-data.png') }}"
                            alt="Image Description">
                      <p class="mb-0">@lang("No Data Found")</p>
                  </div>
              @endif
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
               <h1 class="modal-title text-black fs-5" id="staticBackdropLabel">@lang('Report')</h1>
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
                   <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                   <button type="submit" class="btn-custom">@lang('Confirm')</button>
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
