@extends('admin.layouts.app')
@section('page_title', __('Manage Menu'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Frontend')</li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Manage Menu')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Manage Menu')</h1>
                </div>
            </div>
        </div>
        <div class="row" id="manage-menu">
            <h3 class="ms-1">@lang("Manage Menu For Header")</h3>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title h4">@lang('Pages')</h2>
                    </div>
                    <div class="card-body">
                        @foreach($pages as $key => $page)
                            <div
                                class="js-sortable sortablejs-custom list-group drop-pages listed_arr"
                                data-hs-sortable-options='{
                                       "animation": 150,
                                       "group": {
                                         "name": "MenuSorting",
                                         "pull": "clone",
                                         "put": false
                                       }
                                     }'>
                                <div class="list-group-item mb-2">
                                    <div class="d-flex justify-content-between drop-content">
                                        <span> @lang(ucwords(optional($page->details)->name ?? $page->name)) </span>
                                        <i class="fa-light"></i>
                                    </div>
                                    <input type="hidden" name="menu_item[]"
                                           value="{{ $page->name }}">
                                    <div class="js-sortable list-group nested-list d-none"
                                         data-hs-sortable-options='{
                                        "animation": 150,
                                        "group": "MenuSorting"
                                     }'>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title h4">@lang('Manage Menu')</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.header.menu.item.store') }}" method="post" id="header-form">
                            @csrf
                            <div class="js-sortable list-group manage-menu-drop"
                                 data-hs-sortable-options='{
                                  "animation": 150,
                                  "group": "MenuSorting",
                                  "fallbackOnBody": true
                                }'>
                                @if($headerMenus->menu_items)
                                    @foreach ($headerMenus->menu_items as $key => $value)
                                        <div class="list-group-item mb-2" draggable="false" style="">
                                            <div class="d-flex justify-content-between drop-content">
                                                <span>{{ getPageName(is_numeric($key) ? $value : $key) }}</span>
                                                <i class="fa-light fa-xmark text-danger remove-icon"></i>
                                            </div>
                                            <input type="hidden" value="{{ is_numeric($key) ? $value : $key }}"
                                                   name="menu_item[{{ is_numeric($key) ? $value : $key }}]">
                                            <div class="js-sortable list-group nested-list" data-hs-sortable-options='{
                                                 "animation": 150,
                                                 "group": "MenuSorting"
                                            }'>
                                                @if (is_array($value))
                                                    @include('admin.frontend_management.components.header_menu', ['menuArray' => $value])
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button"
                                    class="btn btn-primary header-form-btn w-100">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-lg-5" id="manage-menu">
            <h3 class="ms-1">@lang("Manage Menu For Footer")</h3>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title h4">@lang('Pages')</h2>
                    </div>
                    <div class="card-body">
                        @foreach($pages as $key => $page)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="js-sortable sortablejs-custom list-group manage-menu-drop-footer"
                                         data-hs-sortable-options='{
                                           "animation": 150,
                                           "group": "listGroup"
                                         }'>
                                        <div class="list-group-item mb-2 d-flex justify-content-between">
                                            <span>@lang(ucwords(optional($page->details)->name ?? $page->name))</span>
                                            <i class="fa-light"></i>
                                            <input type="hidden" name="menu_item[]"
                                                   value="{{ strtolower($page->name) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.footer.menu.item.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" id="usefulLInk">
                                <div class="card-header">
                                    <h2 class="card-title h4">
                                        @lang('Useful Links')
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div class="js-sortable sortablejs-custom list-group useful-link"
                                             data-hs-sortable-options='{
                                                       "animation": 150,
                                                       "group": "listGroup"
                                                     }'>
                                            @if($footerMenus->menu_items)
                                                @foreach($footerMenus->menu_items as $key => $footerMenu)
                                                    @if($key == "useful_link")
                                                        @foreach($footerMenu as  $menu)
                                                            <div
                                                                class="list-group-item mb-2 d-flex justify-content-between">
                                                                <span>@lang(getPageName($menu))</span>
                                                                <i class="fa-light fa-xmark text-danger remove-icon-footer"></i>
                                                                <input type="hidden" name="menu_item[useful_link][]"
                                                                       value="{{ $menu }}">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" id="supportLInk">
                                <div class="card-header">
                                    <h2 class="card-title h4">
                                        @lang('Support Link')
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="js-sortable sortablejs-custom list-group support-link"
                                         data-hs-sortable-options='{
                                           "animation": 150,
                                           "group": "listGroup"
                                         }'>
                                        @if($footerMenus->menu_items)
                                            @foreach($footerMenus->menu_items as $key => $footerMenu)
                                                @if($key == "support_link")
                                                    @foreach($footerMenu as  $menu)
                                                        <div
                                                            class="list-group-item mb-2 d-flex justify-content-between">
                                                            <span>@lang(getPageName($menu))</span>
                                                            <i class="fa-light fa-xmark text-danger remove-icon-footer"></i>
                                                            <input type="hidden" name="menu_item[support_link][]"
                                                                   value="{{ $menu }}">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary w-100">@lang('Save Changes')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js-lib')
    <script src="{{ asset('assets/admin/js/sortable.min.js') }}"></script>
@endpush
@push('script')
    <script>
        'use strict';
        $(document).on('change', '.drop-pages, .manage-menu-drop', function (event, ui) {
            $('.manage-menu-drop').find('.fa-light').addClass('fa-xmark text-danger remove-icon');
            $('.nested-list').removeClass('d-none');
        });

        $(document).on('click', '.header-form-btn', function (e) {
            var $manageMenuDrop = $('.manage-menu-drop');
            updateInputNames($manageMenuDrop);
            $('#header-form').submit();
        });

        function updateInputNames($list) {
            $list.find('.list-group-item').each(function () {
                var $input = $(this).find('input');
                var itemName = $input.val();
                var parentNames = getParentNames($(this));

                var $nestedList = $(this).find('.nested-list').find('.list-group-item');
                if ($nestedList.length <= 3) {
                    if ($nestedList.length <= 0) {
                        var name = 'menu_item' + (parentNames.length > 0 ? '[' + parentNames.join('][') + '][]' : '[]');
                        $input.attr('name', name);
                    } else {
                        $input.removeAttr('name');
                    }
                }


                if ($nestedList.length)
                    updateInputNames($nestedList);

            });
        }

        function getParentNames($item) {
            var parentNames = [];
            $item.parentsUntil('.manage-menu-drop', '.list-group-item').each(function () {
                parentNames.unshift($(this).find('input').val());
            });
            return parentNames;
        }


        $(document).on('change', '.manage-menu-drop-footer', function () {
            let $nestedUsefulLink = $('.useful-link')
            $nestedUsefulLink.find('.fa-light').addClass('fa-xmark text-danger remove-icon');
            let $nestedElementsUseFul = $nestedUsefulLink.find('.list-group-item input');
            $nestedElementsUseFul.each(function () {
                let newName = "menu_item[useful_link][]";
                $(this).attr('name', newName);
                console.log('check', $(this).attr('name'));
            });

            let $nestedListSupport = $('.support-link')
            $nestedListSupport.find('.fa-light').addClass('fa-xmark text-danger remove-icon');
            $nestedListSupport.find('.fa-light').addClass('fa-xmark text-danger remove-icon');
            let $nestedElementsSupport = $nestedListSupport.find('.list-group-item input');
            $nestedElementsSupport.each(function () {
                let newName = "menu_item[support_link][]";
                $(this).attr('name', newName);
                console.log('check', $(this).attr('name'));
            });
        });

        $(document).on('click', ".remove-icon", function () {
            $(this).parent('.drop-content').parent('.list-group-item').remove();
        });

        $(document).on('click', ".remove-icon-footer", function () {
            $(this).parent('.list-group-item').remove();
        });

        (function () {
            HSCore.components.HSSortable.init('.js-sortable')
        })();
    </script>
@endpush





