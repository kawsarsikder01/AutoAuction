@extends($theme.'layouts.user')
@section('title',trans('Listed Vehicle'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">@lang('Listed Vehicle')</h4>

          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <div class="table-search-bar">
                <div class="d-none d-lg-block">
                   <form action="{{route('filter.listed-vehicle')}}" method="get">
                      <div class="row g-3 align-items-end">
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <input type="text" class="form-control" value="{{request()->title}}" name="title" placeholder="Search" />
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
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}" @selected(request()->brand == $brand->id)>{{$brand->name}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="sold_status">
                               <option value="0" @selected(request()->sold_status == 0) >@lang('All')</option>
                               <option value="1" @selected(request()->sold_status == 1)>@lang('Sold')</option>
                               <option value="2" @selected(request()->sold_status == 2)>@lang('Unsold')</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="release_status">
                               <option value="0" @selected(request()->release_status == 0)>@lang('All')</option>
                               <option value="1" @selected(request()->release_status == 1)>@lang('Released')</option>
                               <option value="3" @selected(request()->release_status == 3)>@lang('Unreleased')</option>
                               <option value="2" @selected(request()->release_status == 2)>@lang('Canceled')</option>
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
                      Filter <i class="fa-light fa-filter"></i>
                   </button>
                </div>
             </div>
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">@lang('Title')</th>
                      <th scope="col">@lang('Status')</th>
                      <th scope="col">@lang('Total Bid')</th>
                      <th scope="col">@lang('Sold Status')</th>
                      <th scope="col">@lang('Initial Price')</th>
                      <th scope="col">@lang('Sold Price')</th>
                       <th scope="col">@lang('Released Status')</th>
                      <th scope="col">@lang('Action')</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $key => $vehicle)
                    <tr>
                        <td data-label="@lang('Title')">
                                <a href="{{ route('auction.details', [slug($vehicle->details->title)??'',$vehicle->id]) }}" id="viewAuctionDetails"><span>{{$vehicle->details->title}}</span></a>
                        </td>
                        <td data-label="@lang('Status')">
                            @if($vehicle->status == 0)
                                <span class="badge bg-warning">@lang('Pending')</span>
                            @elseif($vehicle->status == 1)
                                <span class="badge bg-success">@lang('Approved')</span>
                            @elseif($vehicle->status == 2)
                                <span class="badge bg-primary">@lang('Rejected')</span>
                            @endif
                        </td>
                        <td data-label="@lang('Total Bid')">
                            {{count($vehicle->biddingHistory)}}
                        </td>
                        <td data-label="@lang('Sold Status')">
                            @if($vehicle->details->sold_status == 0)
                                <span class="badge bg-primary">@lang('Unsold')</span>
                            @else
                                <span class="badge bg-success">@lang('Sold')</span>
                            @endif
                        </td>
                        <td data-label="@lang('Initial Price')">
                            {{number_format($vehicle->details->price,2,'.',',') .' ' . basicControl()->currency_symbol}}
                        </td>
                        <td data-label="@lang('Sold Price')">
                           @if ($vehicle->details->sold_status == 0 )
                             <span class="badge bg-primary">@lang('Unsold')</span>
                            @else
                            {{number_format($vehicle->details->sold_price,2,'.',',') .' ' . basicControl()->currency_symbol}}
                           @endif
                        </td>
                        <td data-label="@lang('Released Status')">
                            @if ($vehicle->release_status == 0 && $vehicle->details->sold_status == 1)
                                <span class="badge bg-info">@lang('Unreleased')</span>
                            @elseif($vehicle->details->sold_status == 0)
                                <span class="badge bg-primary">@lang('Unsold')</span>
                            @elseif($vehicle->release_status == 1)
                                <span class="badge bg-secondary">@lang('Released')</span>
                            @elseif($vehicle->release_status == 2)
                                <span class="badge bg-primary">@lang('Canceled')</span>
                            @endif
                        </td>
                        <td data-label="@lang('Action')">
                            <div>
                                @if($vehicle->details->sold_status == 1)
                                    @if($vehicle->release_status == 0)
                                        <a href="javascript:void(0);" id="ReleaseProperty" data-route="{{route('user.release.property')}}" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="{{$vehicle->id}}" class="btn-action-icon bg-info" >
                                            <i class="fa-solid fa-truck-fast" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Release Your Vehicle"></i>
                                        </a>
                                    @endif
                                @else
                                    <a href="{{route('user.edit.vehicle',$vehicle->id)}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Edit" class="btn-action-icon bg-info">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                @endif
                                    <a href="{{route('user.vehicle.bidding.history',$vehicle->id)}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Biddding History" class="btn-action-icon bg-warning">
                                        <i class="fa-regular fa-history"></i>
                                    </a>
                                    <a href="{{ route('auction.details', [slug($vehicle->details->title)??'',$vehicle->id]) }}"  data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="View"class="btn-action-icon bg-success">
                                        <i class="fad fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.delete.vehicle', $vehicle->id) }}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Delete" class="btn-action-icon bg-primary">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                            </div>
                         </td>
                    </tr>
                @endforeach
                </tbody>
             </table>
             @if (count($vehicles) == 0)
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
                     {{ $vehicles->appends($_GET)->links($theme.'partials.pagination') }}
                </ul>
             </nav>
          </div>
       </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">@lang('Release Model')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="FormRoute" method="POST">
               @csrf
                <div class="modal-body">
                    <input type="hidden" id="vehicle_id" value="" name="vehicle_id">
                   <span id="setMessage">@lang('Are You Sure You Want To Release Your Vehicle ?')</span>
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
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Search</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('filter.listed-vehicle')}}" method="get">
                    <div class="row g-3 align-items-end">
                        <div class="input-box col-12">
                            <input type="text" value="{{request()->title}}" name="title" class="form-control" placeholder="Search" />
                        </div>
                        <div class="input-box col-12">
                            <select class="js-example-basic-single form-control" name="category">
                                <option value="">@lang('Select Category')</option>
                                @foreach($categories as $categorie)
                                    <option value="{{$categorie->id}}" @selected(request()->category == $categorie->id)>{{$categorie->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-box col-12">
                            <select class="js-example-basic-single form-control" name="brand">
                                <option value="">@lang('Select Brand')</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}" @selected(request()->brand == $brand->id)>{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-box col-12">
                            <select class="js-example-basic-single form-control" name="sold_status">
                                <option value="0" @selected(request()->sold_status == 0) >@lang('All')</option>
                                <option value="1" @selected(request()->sold_status == 1)>@lang('Sold')</option>
                                <option value="2" @selected(request()->sold_status == 2)>@lang('Unsold')</option>
                            </select>
                        </div>
                        <div class="input-box col-12">
                            <select class="js-example-basic-single form-control" name="release_status">
                                <option value="0" @selected(request()->release_status == 0)>@lang('All')</option>
                                <option value="1" @selected(request()->release_status == 1)>@lang('Released')</option>
                                <option value="3" @selected(request()->release_status == 3)>@lang('Unreleased')</option>
                                <option value="2" @selected(request()->release_status == 2)>@lang('Canceled')</option>
                            </select>
                        </div>
                        <div class="input-box col-12">
                            <button class="btn-custom w-100"><i class="fal fa-search"></i> Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
         $(document).ready(function(){
           if($('#ReleaseProperty').length){
                $('#FormRoute').attr('action', $('#ReleaseProperty').data('route'));
                $('#vehicle_id').attr('value',$('#ReleaseProperty').data('id'));
           }
        })
    </script>
@endpush
