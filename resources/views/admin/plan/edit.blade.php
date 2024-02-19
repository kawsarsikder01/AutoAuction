@extends('admin.layouts.app')
@section('page_title', __('Create Page'))
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
                                aria-current="page">@lang("Create Plan")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Create Plan")</h1>
                </div>
            </div>
        </div>

        <div class="alert alert-soft-dark mb-5 " role="alert">
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
                        <p class="mb-0">@lang("You are createing plan for `$language->name` version.")</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title mt-2">@lang("Create Plan")</h3>
                        </div>
                        <div class="card-body mt-2">
                            <form action="{{ route("admin.plan.update",$plan->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="language_id" value="{{$language->id}}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="PlanName" class="form-label  ">@lang("Plan Name")</label>
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" value="{{$plan->plan_name}}" class="form-control change_name_input" name="plan_name"
                                                       id="PlanName"
                                                       placeholder="@lang("Plan Name")" autocomplete="off">
                                            </div>
                                            @error("name")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label for="PlanPrice" class="form-label  ">@lang("Plan Price")</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" value="{{$plan->price}}" name="price" placeholder="Plan Price" aria-label="Plan Price" aria-describedby="PlanPrice">

                                                <span class="input-group-text" id="PlanPrice">{{basicControl()->base_currency}}</span>
                                            </div>

                                            @error("price")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="PlanShortTitle"
                                                   class="form-label ">@lang("Plan short title")</label>
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control change_name_input" name="title"
                                                       id="PlanShortTitle" value="{{$plan->title}}"
                                                       placeholder="@lang("Plan short title")" autocomplete="off">
                                            </div>
                                            @error("title")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="NumberOfListing"
                                                   class="form-label">@lang("Number of Listing")
                                                <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="@lang('User can create maximum listing according to plan.')" data-bs-original-title="@lang('User can create maximum listing according to plan.')"></i>
                                            </label>
                                            <input type="text" class="form-control change_name_input"
                                                   name="number_of_listing"
                                                   id="NumberOfListing"
                                                   value="{{$plan->number_of_listing}}"
                                                   placeholder="@lang("Number of Listing")"
                                                   autocomplete="off">

                                            @error("number_of_image")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="NumberOfImage"
                                                   class="form-label ">@lang("Number of Image")
                                                <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="@lang('User can add maximum images per listing.')" data-bs-original-title="@lang('User can add maximum images per listing.')"></i>
                                            </label>
                                            <input type="number" class="form-control" name="number_of_images"
                                                    id="NumberOfImage"  placeholder="@lang('Number Of Images Per listing')"
                                                   aria-label="Number Of Images Per listing"
                                                   value="{{$plan->number_of_images}}"
                                                   >


                                            @error("expiry_time")
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <label for="PlanExpiryTime"
                                               class="form-label ">@lang("Plan Expiry Time")</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="expiry_time" value="{{$plan->expiry_time}}"
                                                   placeholder="Plan Expiry Time" id="PlanExpiryTime" aria-label="Plan Expiry Time" >

                                            <!-- Select -->
                                            <div class="tom-select-custom">
                                                <select class="js-select form-select" name="expiry_time_type"
                                                        autocomplete="off"
                                                        data-hs-tom-select-options='{
                                                        "dropdownWidth": "300px",
                                                        "dropdownLeft": true
                                                      }'>
                                                    <option value="days"@selected($plan->expiry_time_type == 'days'?true:false)>Days</option>
                                                    <option value="month"@selected($plan->expiry_time_type == 'month'?true:false)>Month</option>
                                                    <option value="year"@selected($plan->expiry_time_type == 'year'?true:false)>Year</option>
                                                </select>
                                            </div>
                                        </div>


                                        @error("expiry_time")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        @error("expiry_time_type")
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>


                                <div class="list-group list-group-lg list-group-flush list-group-no-gutters">
                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">Access Auction</h5>
                                                        <p class="fs-5 text-body mb-0">Enable auction access to the auction platform and seller access to the bidding process.</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="access_auction" value="0">
                                                            <input class="form-check-input" name="access_auction"
                                                                   type="checkbox" id="activeAccessAuction" value="1" @checked($plan->access_auction == 1?true:false)>
                                                            <label class="form-check-label"
                                                                   for="activeAccessAuction"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">Promoted Listing</h5>
                                                        <p class="fs-5 text-body mb-0">If promoted listing is enabled , the seller's products will be listed according to priority.</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="promoted_listing" value="0">
                                                            <input class="form-check-input" name="promoted_listing"
                                                                   type="checkbox" id="activePromotedListing" value="1" @checked($plan->promoted_listing == 1?true:false)>
                                                            <label class="form-check-label"
                                                                   for="activePromotedListing"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->
                                    <!-- Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">Share Other Platform</h5>
                                                        <p class="fs-5 text-body mb-0">Enable sharing option for seller to share his products on other platforms like Facebook, Instagram.</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="share_other_platform" value="0">
                                                            <input class="form-check-input" name="share_other_platform"
                                                                   type="checkbox" id="activeShareOtherPlatform" value="1" @checked($plan->share_other_platform == 1?true:false)>
                                                            <label class="form-check-label"
                                                                   for="activeShareOtherPlatform"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->
                                     <!-- Item -->
                                     <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col-sm mb-2 mb-sm-0">
                                                        <h5 class="mb-0">Plan Status</h5>
                                                        <p class="fs-5 text-body mb-0">Enable plan status to show plan in  frontend .</p>
                                                    </div>
                                                    <div class="col-sm-auto d-flex align-items-center">
                                                        <div class="form-check form-switch form-switch-google">
                                                            <input type="hidden" name="status" value="0">
                                                            <input class="form-check-input" name="status"
                                                                   type="checkbox" id="activeStatus" value="1" @checked($plan->status == 1?true:false)>
                                                            <label class="form-check-label"
                                                                   for="activeStatus"></label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Item -->
                                </div>


                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit"
                                            class="btn btn-primary submit_btn">@lang("Save & Publish")</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
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







