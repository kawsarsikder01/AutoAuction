@extends($theme.'layouts.user')
@section('title',trans('Bidding History'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">@lang('User Bidding History')</h4>
          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <div class="table-search-bar">
                <div class="d-none d-lg-block">
                   <form action="{{route('filter.bidding-history')}}" method="get">
                      <div class="row g-3 align-items-end">
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <input type="text" class="form-control" value="{{request()->title}}" name="title" placeholder="Search" />
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="sold_status">
                                <option value="0" @selected(request()->sold_status == 0)>@lang('Select Sold Status')</option>
                               <option value="1" @selected(request()->sold_status == 1)>@lang('Sold')</option>
                               <option value="2" @selected(request()->sold_status == 2)>@lang('Unsold')</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="win_status">
                               <option value="0" @selected(request()->win_status == 0)>@lang('Select Win Status')</option>
                               <option value="1" @selected(request()->win_status == 1)>@lang('Win')</option>
                               <option value="2" @selected(request()->win_status == 2)>@lang('Not Win')</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="category">
                                <option value="">@lang('Select Category')</option>
                                @foreach($categories as $categorie)
                                    <option value="{{$categorie->id}}" @selected(request()->category == $categorie->id)>{{$categorie->name}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="brand">
                                <option value="">@lang('Select Brand')</option>
                                @foreach($brands  as $brand)
                                    <option value="{{$brand->id}}" @selected(request()->brand == $brand->id)>{{$brand->name}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <button class="btn-custom w-100"><i class="fal fa-search"></i> @lang('Filter')</button>
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
                      @lang('Filter') <i class="fa-light fa-filter"></i>
                   </button>
                </div>
             </div>
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">@lang('Title')</th>
                      <th scope="col">@lang('Sold Status')</th>
                      <th scope="col">@lang('Your Bid Amount')</th>
                      <th scope="col">@lang('Sold Price')</th>
                      <th scope="col">@lang('Win Status')</th>
                      <th scope="col">@lang('Action')</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($biddingHistorys as $key => $biddingHistory)
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
                                @if(checkReport($biddingHistory) == false)
                                    <a href="javascript:void(0);"   data-route="{{route('user.store.report',[$biddingHistory->user_id,$biddingHistory->vehicle->user_id,$biddingHistory->vehicle_id])}}" class="btn-action-icon bg-danger report" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <i class="fal fa-flag-alt" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report" aria-hidden="true"></i>
                                    </a>
                                @endif
                                    <a href="{{route('user.messages',$biddingHistory->vehicle->user_id)}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Message" class="btn-action-icon bg-warning">
                                        <i class="fa-brands fa-rocketchat"></i>
                                    </a>
                                 @if ($biddingHistory->vehicle->payment_status == 0)
                                 <a href="javascript:void(0);"  data-id="{{$biddingHistory->vehicle->id}}" data-message="Are You Sure You Want To Pay ?" data-route="{{route('user.confirm.payment')}}" class="btn-action-icon bg-primary payment" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                  <i class="fa-brands fa-amazon-pay" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Pay Now"></i>
                                 </a>
                                 @endif
                              @endif
                                  <a href="{{ route('auction.details',[slug($biddingHistory->vehicle->details->title??''),$biddingHistory->vehicle_id]) }}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="View" class="btn-action-icon bg-success">
                                      <i class="fad fa-eye"></i>
                                  </a>
                            </div>
                         </td>
                    </tr>
                @endforeach
                </tbody>
             </table>
             @if (count($biddingHistorys) == 0)
                <div class="text-center p-4">
                    <img  class="dataTables-image mb-3 w-50"
                         src="{{ asset('assets/admin/img/oc-error.svg') }}"
                         alt="Image Description">
                    <p class="mb-0">@lang("No Bidding History Found")</p>
                </div>
                @endif

             <!-- pagination -->
             <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end mt-4">
                     {{ $biddingHistorys->appends($_GET)->links($theme.'partials.pagination') }}
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
               <h1 class="modal-title fs-5" id="staticBackdropLabel">@lang('Payment Model')</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <form action="" id="PaymentRoute" method="POST">
              @csrf
               <div class="modal-body">
                   <input type="hidden" id="vehicle_id" value="" name="vehicle_id">
                  <span id="setMessage"></span>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                   <button type="submit" class="btn-custom">@lang('Confirm')</button>
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
               <h1 class="modal-title fs-5" id="staticBackdropLabel">@lang('Report')</h1>
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

            $('.report').on('click',function (){
                let route = $(this).data('route');
                console.log(route);
                $('#FormRoute').attr('action', route);
            })


           $('.payment').on('click',function (){
               let route = $(this).data('route');
               let id = $(this).data('id');
               let message = $(this).data('message');
               $('#vehicle_id').attr('value',id);
               $('#PaymentRoute').attr('action',route);
               $('#setMessage').text(message);
           })

        });
    </script>
@endpush
