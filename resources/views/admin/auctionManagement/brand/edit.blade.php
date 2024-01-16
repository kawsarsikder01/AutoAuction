@extends('admin.layouts.app')
@section('page_title', __('Update Page'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang("Update Category")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Update Category")</h1>
                </div>
            </div>
        </div>

        <div class="alert alert-soft-dark mb-5" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img class="avatar avatar-xl alert_image"
                         src="{{ asset('assets/admin/img/oc-megaphone.svg') }}"
                         alt="Image Description" data-hs-theme-appearance="default">
                    <img class="avatar avatar-xl alert_image"
                         src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                         alt="Image Description" data-hs-theme-appearance="dark">
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">@lang("You are update category for ` $defaultLanguage->name` version.")</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{route("admin.update.car.brand",$brand->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="d-grid gap-3 gap-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang("Update Brand")</h2>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="language_id" value="{{$defaultLanguage->id}}">
                                <div class="row mb-4">
                                   <div class="col-md-12">
                                    <label for="NameLabel" class="form-label  mb-3">@lang("Name")</label>
                                    <div class="input-group input-group-sm-vertical">
                                        <input type="text" class="form-control change_name_input" name="name"
                                               id="NameLabel" value="{{isset($brand)?$brand->name:''}}"
                                               placeholder="@lang("Category Name")" autocomplete="off">
                                    </div>
                                    @error("name")
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                   </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="row form-check form-switch" for="unlimitedstatus">
                                            <span class="col-8 col-sm-9 ms-0">
                                              <span class="text-dark">@lang("Brand Status")</span>
                                            </span>
                                            <span class="col-4 col-sm-3 text-end">
                                                <input type="checkbox" name="status" class="form-check-input is-valid" id="validSwitch" @if(isset($brand) && $brand->status == 1) checked @endif >
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary mt-3" 
                                >@lang("Save")</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            HSCore.components.HSTomSelect.init('.js-select');
            new HSFileAttach('.js-file-attach')
            $(document).on('input', ".change_name_input", function (e) {
                let inputValue = $(this).val();
                let final_value = inputValue.toLowerCase().replace(/\s+/g, '-');
                $('.set-slug').val(final_value);
            });
            $('.dropdown-toggle').dropdown();
        });
    </script>

    <script src="{{ asset("assets/admin/js/hs-file.min.js") }}"></script>
@endpush








