@extends($theme.'layouts.user')
@section('title',trans('Purchase History'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">Reports</h4>
          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">@lang('Plan Name')</th>
                      <th scope="col">@lang('Price')</th>
                       <th scope="col">@lang('Transaction Id')</th>
                       <th scope="col">@lang('Payment Method')</th>
                       <th scope="col">@lang('Listing Limit')</th>
                      <th scope="col">@lang('Purchase Date')</th>
                      <th scope="col">@lang('Expire Date')</th>
                      <th scope="col">@lang('Validity')</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($purchaseHistorys as $key => $purchaseHistory)
                    <tr>
                        <td data-label="@lang('Plan Name')">
                            {{$purchaseHistory->plan_name}}
                        </td>
                        <td data-label="@lang('Price')">
                            {{currencyPosition($purchaseHistory->price)}}
                        </td>
                        <td data-label="@lang('Transaction Id')">
                            {{$purchaseHistory->trx_id}}
                        </td>
                        <td data-label="@lang('Payment Method')">
                            {{$purchaseHistory->payment_method}}
                        </td>
                        <td data-label="@lang('Listing Limit')">
                            {{$purchaseHistory->noOfListing}}
                        </td>

                        <td data-label="@lang('Purchase Date')">
                          {{dateTime($purchaseHistory->purchase_date)}}
                        </td>
                        <td data-label="@lang('Plan Name')">
                            {{dateTime($purchaseHistory->expiry_date)}}
                        </td>
                        <td data-label="@lang('Validity')">
                            @if($purchaseHistory->status == 1)
                                <span class="badge bg-success">@lang('Active')</span>
                            @else
                                <span class="badge bg-primary">@lang('Expired')</span>
                            @endif
                         </td>
                    </tr>
                @endforeach
                </tbody>
             </table>
             @if (count($purchaseHistorys) == 0)
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
                     {{ $purchaseHistorys->appends($_GET)->links($theme.'partials.pagination') }}
                </ul>
             </nav>
          </div>
       </div>
    </div>
 </div>
@endsection
