@extends('admin.layouts.app')
@section('page_title',__('Blog Category'))
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-sm mb-2 mb-sm-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:void(0)">@lang("Dashboard")</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang("Blog Category")</li>
                    </ol>
                </nav>
                <h1 class="page-header-title">@lang("Blog Category")</h1>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header card-header-content-md-between">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.createBlogCategory') }}" class="btn btn-primary">@lang('Add Category')</a>
            </div>
                <div class="dropdown">
                    <button type="button" class="btn btn-white btn-sm w-100"
                            id="dropdownMenuClickable" data-bs-auto-close="false"
                            id="usersFilterDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="bi-filter me-1"></i> @lang('Filter')
                    </button>
                    <div
                        class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered filter_dropdown"
                        aria-labelledby="dropdownMenuClickable">
                        <div class="card">
                            <div class="card-header card-header-content-between">
                                <h5 class="card-header-title">@lang('Filter Category')</h5>
                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2"
                                        id="filter_close_btn">
                                    <i class="bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4">
                                        <small class="text-cap text-body">@lang("Category Status")</small>
                                        <div class="tom-select-custom">
                                            <select
                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                id="select_status"
                                                data-target-column-index="4" data-hs-tom-select-options='{
                                                    "placeholder": "Any status",
                                                    "searchInDropdown": false,
                                                    "hideSearch": true,
                                                    "dropdownWidth": "10rem"
                                                    }'>
                                                <option value="all"
                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-secondary"></span>@lang("All Status")</span>'>
                                                    @lang("All Status")
                                                </option>
                                                <option value="1"
                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>'>
                                                    @lang("Active")
                                                </option>
                                                <option value="0"
                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-danger"></span>Inactive</span>'>
                                                    @lang("Inactive")
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <span class="text-cap text-body">@lang("Name")</span>
                                        <input type="text" class="form-control" id="username_filter_input"
                                            autocomplete="off">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="button" id="filter_button"
                                            class="btn btn-primary">@lang('Apply')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="table-responsive">
            <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                <thead class="thead-light">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('Name')</th>
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
                    @foreach ($blogCategory as $item)
                        <tr>
                            <td>{{++$sl}}</td>
                            <td>{{$item->name}}</td>
                            
                            <td ><span style="font-size: 12px;" class="badge  {{$item->status == 1 ? 'bg-soft-success text-success':'bg-soft-danger text-danger'}} bg-soft-success text-success"><span class="legend-indicator bg-{{$item->status == 1? 'success':'danger'}}"></span>{{$item->status == 1 ? 'Active':'Inactive'}}</span></td>
                            <td class="text-center">
                                @if($item->type !== 2)
                                    @if($item->language_id)
                                        <a href="{{ route('admin.editBlogCategory', [$item->id,$item->language_id]) }}"
                                           class="btn btn-white btn-icon btn-sm flag-btn"> <i
                                                class="bi bi-check2"></i></a>
                                    @endif
                                    @foreach($languages as $language)
                                        @if($item->language_id !== $language->id)
                                            <a href="{{ route('admin.editBlogCategory',[$item->id,$language->id]) }}"
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
                                    <a class="btn btn-white btn-sm" href="{{route('admin.editBlogCategory',[$item->id,$language->id])}}">
                                        <i class="bi-pencil-fill me-1"></i> Edit</a>
                            
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="pageEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="pageEditDropdown">
                                            <form  action="{{ route('admin.deleteBlogCategory') }}" method="POST" >
                                                @csrf
                                                <input type="hidden" name="id" value="{{$item->id}}">
                                                <button type="submit" class="dropdown-item deleteBtn"data-pagename="Home"data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                    <i class="bi-trash dropdown-item-icon"></i>@lang('Delete')</button>
                                            </form>
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
@endsection
