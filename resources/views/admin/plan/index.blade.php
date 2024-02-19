@extends('admin.layouts.app')
@section('page_title',__('Plan'))
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:void(0)">@lang("Dashboard")</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang("Plan")</li>
                    </ol>
                </nav>
                <h1 class="page-header-title">@lang("Plan")</h1>
            </div>
        </div>
    </div>

    <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.create.plan') }}" class="btn btn-primary">@lang('Create Plan')</a>
            </div>

        <div class="table-responsive">
            <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                <thead class="thead-light">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('Plan Name')</th>
                    <th>@lang('Price')</th>
                    <th>@lang('Expiry Time')</th>
                    <th>@lang('Status')</th>
                    <th class="text-center">
                        @foreach($languages as $language)
                            <img class="avatar avatar-xss avatar-square me-2"
                                 src="{{ getFile($language->flag_driver, $language->flag) }}"
                                 alt="{{ $language->name }} Flag">
                        @endforeach
                    </th>
                    <th>@lang('Action')</th>
                </tr>
                </thead>

                <tbody>
                    @php
                        $sl = 0;
                    @endphp
                    @foreach ($plans as $item)
                        <tr>
                            <td>{{++$sl}}</td>
                            <td>{{$item->plan_name}}</td>
                            <td>{{$item->price == 0 ? 'Free':  currencyPosition($item->price)}}</td>
                            <td>{{$item->expiry_time ==0 ? 'Unlimited':$item->expiry_time. ' '. ucfirst($item->expiry_time_type)}}</td>

                            <td ><span  class="badge  {{$item->status == 1 ? 'bg-soft-success text-success':'bg-soft-danger text-danger'}} bg-soft-success text-success"><span class="legend-indicator bg-{{$item->status == 1? 'success':'danger'}}"></span>{{$item->status == 1 ? 'Active':'Inactive'}}</span></td>
                            <td class="text-center">
                                @if($item->type !== 2)
                                    @if($item->language_id)
                                        <a href="{{ route('admin.plan.edit', [$item->id,$item->language_id]) }}"
                                           class="btn btn-white btn-icon btn-sm flag-btn"> <i
                                                class="bi bi-check2"></i></a>
                                    @endif
                                    @foreach($languages as $language)
                                        @if($item->language_id !== $language->id)
                                            <a href="{{ route('admin.plan.edit',[$item->id,$language->id]) }}"
                                               class="btn btn-white btn-icon btn-sm flag-btn"
                                               target="_blank"> <i class="bi-pencil"></i></a>
                                        @endif
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-white btn-sm" href="{{route('admin.plan.edit',[$item->id,$defaultLanguage->id])}}">
                                        <i class="bi-pencil-fill me-1"></i> Edit</a>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="pageEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="pageEditDropdown">
                                            <a class="dropdown-item deleteBtn text-danger"
                                               href="javascript:void(0)"
                                               data-route="{{ route("admin.plan.destroy", $item->id) }}"
                                               data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi-trash dropdown-item-icon text-danger"></i> @lang("Delete")
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
data-bs-backdrop="static"
aria-hidden="true">
<div class="modal-dialog" role="document">
   <div class="modal-content">
       <div class="modal-header">
           <h4 class="modal-title" id="deleteModalLabel"><i
                   class="bi bi-check2-square"></i> @lang("Confirmation")</h4>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <form action="" method="post" class="setRoute">
           @csrf
           @method("delete")
           <div class="modal-body">
               <p>@lang("Do you want to delete this plan")</p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
               <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
           </div>
       </form>
   </div>
</div>
</div>
<!-- End Delete Modal -->
@endsection


@push('script')
    <script>
        "use script";
        $(document).ready(function () {
            $('.deleteBtn').on('click', function () {
                let route = $(this).data('route');
                $('.setRoute').attr('action', route);
            })
        })
    </script>
@endpush
