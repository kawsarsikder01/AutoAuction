@extends($theme.'layouts.user')
@section('title',trans('Listed Vehicle'))
@section('content')
<div class="container-fluid">
    <div class="main row">
       <div class="col-12">
          <div class="dashboard-heading">
             <h4 class="mb-0">Listed Vehicle</h4>

          </div>

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <div class="table-search-bar">
                <div class="d-none d-lg-block">
                   <form action="{{route('filter.listed-vehicle')}}" method="get">
                      <div class="row g-3 align-items-end">
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <input type="text" class="form-control" name="title" placeholder="Search" />
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="category">
                               <option value="">Select Category</option>
                                @foreach($categories as $categorie)
                                    <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                                @endforeach


                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="brand">
                               <option value="">Select Brand</option>
                                @foreach($brands as $brands)
                                    <option value="{{$brands->id}}">{{$brands->name}}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="sold_status">
                               <option value="">Select Sold Status</option>
                               <option value="1">Sold</option>
                               <option value="0">Unsold</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="release_status">
                               <option value="">Select Release Status</option>
                               <option value="1">Released</option>
                               <option value="0">Unreleased</option>
                               <option value="2">Canceled</option>
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
                      <th scope="col">Status</th>
                      <th scope="col">Total Bid</th>
                      <th scope="col">Sold Status</th>
                      <th scope="col">Initial Price</th>
                      <th scope="col">Sold Price</th>
                       <th scope="col">Released Status</th>
                      <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $key => $vehicle)
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
                        <td>
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
                                <a href="{{route('user.vehicle.bidding.history',$vehicle->id)}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Biddding History" class="btn-action-icon bg-warning">
                                    <i class="fa-regular fa-history"></i>
                                </a>
                                    <a href="{{ route('auction.details', [slug($vehicle->details->title)??'',$vehicle->id]) }}" class="btn-action-icon bg-success">
                                        <i class="fad fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.delete.vehicle', $vehicle->id) }}" class="btn-action-icon bg-primary">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                @else
                                <a href="{{route('user.vehicle.bidding.history',$vehicle->id)}}" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Biddding History" class="btn-action-icon bg-warning">
                                    <i class="fa-regular fa-history"></i>
                                </a>
                                    <a href="{{route('user.edit.vehicle',$vehicle->id)}}" class="btn-action-icon bg-info">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('auction.details', [slug($vehicle->details->title)??'',$vehicle->id]) }}" class="btn-action-icon bg-success">
                                        <i class="fad fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user.delete.vehicle', $vehicle->id) }}" class="btn-action-icon bg-primary">
                                        <i class="fa-solid fa-trash"></i>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Release Model</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="FormRoute" method="POST">
               @csrf
                <div class="modal-body">
                    <input type="hidden" id="vehicle_id" value="" name="vehicle_id">
                   <span id="setMessage">Are You Sure You Want To Release Your Vehicle ?</span>
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
           if($('#ReleaseProperty').length){
                $('#FormRoute').attr('action', $('#ReleaseProperty').data('route'));
                $('#vehicle_id').attr('value',$('#ReleaseProperty').data('id'));
           }
        })
    </script>
@endpush
