@extends($theme.'layouts.user')
@section('title',trans('Bidding History'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">User Bidding History</h4>
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
                      <th scope="col">Title</th>
                      <th scope="col">Sold Status</th>
                      <th scope="col">Your Bid Amount</th>
                      <th scope="col">Sold Price</th>
                      <th scope="col">Win Status</th>
                      <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($biddingHistorys as $key => $biddingHistory)
                    <tr>
                        <td data-label="@lang('Title')">
                                {{$biddingHistory->vehicle->details->title}}
                        </td>
                        <td data-label="@lang('Sold Status')">
                            @if($biddingHistory->vehicle->details->sold_status == 0)
                                <span class="badge bg-primary">@lang('Unsold')</span>
                            @else
                                <span class="badge bg-success">@lang('Sold')</span>
                            @endif
                        </td>
                        <td data-label="@lang('Your Bid Amount')">
                            {{number_format( $biddingHistory->bid_amount, 2, '.', ',') .' ' . basicControl()->currency_symbol}}
                        </td>
                        <td data-label="@lang('Sold Price')">
                           @if ($biddingHistory->vehicle->details->sold_status == 0 )
                             <span class="badge bg-primary">@lang('Unsold')</span>
                            @else
                            {{number_format($biddingHistory->vehicle->details->sold_price, 2, '.', ',') .' ' . basicControl()->currency_symbol}}
                           @endif
                        </td>
                        <td data-label="@lang('Status')">
{{--                            @dd($biddingHistory->)--}}
                           @if($biddingHistory->wining_status == 0)
                               <span class="badge bg-primary">@lang('You are not Win')</span>
                           @elseif($biddingHistory->wining_status == 1)
                               <span class="badge bg-success">@lang('Win')</span>
                           @endif
                       </td>
                        <td data-label="@lang('Action')">
                            <div>
                              @if ($biddingHistory->wining_status == 1)
                              <a href="javascript:void(0);" id="report"   data-route="{{route('user.store.report',[$biddingHistory->user_id,$biddingHistory->vehicle->user_id,$biddingHistory->vehicle->id])}}" class="btn-action-icon bg-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                 <i class="fal fa-flag-alt" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report" aria-hidden="true"></i>
                             </a>
                             
                             
                             @if ($biddingHistory->vehicle->payment_status == 0)
                             <a href="javascript:void(0);" id="payment" data-id="{{$biddingHistory->vehicle->id}}" data-message="Are You Sure You Want To Pay ?" data-route="{{route('user.confirm.payment')}}" class="btn-action-icon bg-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                              <i class="fa-brands fa-amazon-pay" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Pay Now"></i>
                             </a>
                             @endif
                              <a href="{{ route('auction.details',[slug($biddingHistory->vehicle->details->title??''),$biddingHistory->vehicle_id]) }}" class="btn-action-icon bg-success">
                                 <i class="fad fa-eye"></i>
                              </a>
                              @else
                              <a href="{{ route('auction.details',[slug($biddingHistory->vehicle->details->title??''),$biddingHistory->vehicle_id]) }}" class="btn-action-icon bg-success">
                                 <i class="fad fa-eye"></i>
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
<div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h1 class="modal-title fs-5" id="staticBackdropLabel">Payment Model</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <form action="" id="PaymentRoute" method="POST">
              @csrf
               <div class="modal-body">
                   <input type="hidden" id="vehicle_id" value="" name="vehicle_id">
                  <span id="setMessage"></span>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="btn-custom">Confirm</button>
               </div>
           </form>
       </div>
   </div>
</div>
 <!-- Modal -->
<div class="modal fade"  id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h1 class="modal-title fs-5" id="staticBackdropLabel">Report</h1>
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
            if($('#report').length){
               $('#FormRoute').attr('action', $('#report').data('route'));
            }
            if($('#payment').length){
               $('#vehicle_id').attr('value',$('#payment').data('id'));
               $('#PaymentRoute').attr('action',$('#payment').data('route'));
               $('#setMessage').text($('#payment').data('message'));
            }
        });
    </script>
@endpush
