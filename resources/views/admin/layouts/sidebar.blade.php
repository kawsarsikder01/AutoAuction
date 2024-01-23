<!-- Navbar Vertical -->
<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl {{in_array(session()->get('themeMode'), [null, 'auto'] )?  'navbar-dark bg-dark navbar-vertical-aside-initialized' : 'navbar-light bg-white'}}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ $basicControl->site_title }}">
                <img class="navbar-brand-logo navbar-brand-logo-auto"
                src="{{ getFile(session()->get('themeMode') == 'auto'?$basicControl->admin_dark_mode_logo_driver : $basicControl->admin_logo_driver, session()->get('themeMode') == 'auto'?$basicControl->admin_dark_mode_logo:$basicControl->admin_logo, true) }}"
                alt="{{ $basicControl->site_title }} Logo"
                data-hs-theme-appearance="default">

                <img class="navbar-brand-logo"
                     src="{{ getFile($basicControl->admin_dark_mode_logo_driver, $basicControl->admin_dark_mode_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="dark">
                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="Logo"
                     data-hs-theme-appearance="dark">
            </a>
            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                   data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                   data-bs-toggle="tooltip"
                   data-bs-placement="right"
                   title="Collapse">
                </i>
                <i
                    class="bi-arrow-bar-right navbar-toggler-full-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Expand"
                ></i>
            </button>
            <!-- End Navbar Vertical Toggle -->

            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">

                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.dashboard']) }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">@lang("Dashboard")</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.blog.list', 'admin.blog.create','admin.blog.update'], 3) }}"
                           href="#navbarVerticalBlog"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalBlog"
                           aria-expanded="false"
                           aria-controls="navbarVerticalBlog">
                            <i class="bi bi-union nav-icon"></i>
                            <span class="nav-link-title">@lang('Blog Management')</span>
                        </a>

                        <div id="navbarVerticalBlog"
                             class="nav-collapse collapse {{ menuActive(['admin.blogCategory', 'admin.blogs'], 2) }}"
                             data-bs-parent="#navbarVerticalBlog">
                            <a class="nav-link {{ menuActive(['admin.blogCategory']) }}"
                               href="{{ route('admin.blogCategory') }}">@lang('Blog Category')</a>

                            <a class="nav-link  {{ menuActive(['admin.blogs']) }}"
                               href="{{ route("admin.blogs") }}">@lang('Blogs')</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.plan.list']) }}"
                           href="{{ route('admin.plan.list') }}" data-placement="left">
                            <i class="bi bi-box-seam nav-icon"></i>
                            <span class="nav-link-title">@lang('Plan')</span>
                        </a>
                    </div>
                      <div class="nav-item">
                          <a class="nav-link dropdown-toggle {{ menuActive(['admin.category', 'admin.brand'], 2) }}"
                             href="#navbarVerticalAuction"
                             role="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#navbarVerticalAuction"
                             aria-expanded="false"
                             aria-controls="navbarVerticalAuction">
                              <i class="bi bi-calendar nav-icon"></i>
                              <span class="nav-link-title">@lang('Auction Management')</span>
                          </a>
                          <div id="navbarVerticalAuction"
                               class="nav-collapse collapse {{ menuActive(['admin.category', 'admin.brand'], 2) }}"
                               data-bs-parent="#navbarVerticalAuction">
                              <a class="nav-link {{ menuActive(['admin.category']) }}"
                                 href="{{ route('admin.car.category') }}">@lang('Category')</a>

                              <a class="nav-link  {{ menuActive(['admin.brand']) }}"
                                 href="{{ route("admin.car.brand") }}">@lang('Brand')</a>
                          </div>
                      </div>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.approved.vehicle', 'admin.pending.vehicle'], 2) }}"
                           href="#navbarVerticalVehicleRequest"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalVehicleRequest"
                           aria-expanded="false"
                           aria-controls="navbarVerticalVehicleRequest">
                            <i class="bi bi-truck nav-icon"></i>
                            <span class="nav-link-title">@lang('Vehicle Request')</span>
                        </a>
                        <div id="navbarVerticalVehicleRequest"
                             class="nav-collapse collapse {{ menuActive(['admin.pending.vehicle', 'admin.approved.vehicle','admin.rejected.vehicle'], 3) }}"
                             data-bs-parent="#navbarVerticalVehicleRequest">
                            <a class="nav-link {{ menuActive(['admin.pending.vehicle']) }}"
                               href="{{ route('admin.pending.vehicle') }}">@lang('Pending Vehicle')</a>

                            <a class="nav-link  {{ menuActive(['admin.approved.vehicle']) }}"
                               href="{{ route("admin.approved.vehicle") }}">@lang('Approved Vehicle')</a>
                            <a class="nav-link  {{ menuActive(['admin.rejected.vehicle.list']) }}"
                               href="{{ route("admin.vehicle.rejected.list") }}">@lang('Rejected Vehicle')</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.reports.list']) }}"
                           href="{{ route('admin.reports') }}" data-placement="left">
                            <i class="bi bi-flag nav-icon"></i>
                            <span class="nav-link-title">@lang('Reports')</span>
                        </a>
                    </div>
                    <span class="dropdown-header mt-4">@lang('Transactions')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.transaction']) }}"
                           href="{{ route('admin.transaction') }}" data-placement="left">
                            <i class="bi bi-send nav-icon"></i>
                            <span class="nav-link-title">@lang("Transaction")</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.payout.log']) }}"
                           href="{{ route('admin.payout.log') }}" data-placement="left">
                            <i class="bi bi-wallet2 nav-icon "></i>
                            <span class="nav-link-title">@lang("Withdraw Log")</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.payment.log']) }}"
                           href="{{ route('admin.payment.log') }}" data-placement="left">
                            <i class="bi bi-credit-card-2-front nav-icon"></i>
                            <span class="nav-link-title">@lang("Payment Log")</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.payment.pending']) }}"
                           href="{{ route('admin.payment.pending') }}" data-placement="left">
                            <i class="bi bi-cash nav-icon"></i>
                            <span class="nav-link-title">@lang("Payment Request")</span>
                        </a>
                    </div>

                    <span class="dropdown-header mt-4"> @lang("Ticket Panel")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.ticket'], 3) }}"
                           href="#navbarVerticalTicketMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalTicketMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalTicketMenu">
                            <i class="fa-light fa-headset nav-icon"></i>
                            <span class="nav-link-title">@lang("Support Ticket")</span>
                        </a>
                        <div id="navbarVerticalTicketMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.ticket'], 2) }}"
                             data-bs-parent="#navbarVerticalTicketMenu">
                            <a class="nav-link {{ request()->is('admin/tickets/all') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'all') }}">@lang("All Tickets")
                            </a>
                            <a class="nav-link {{ request()->is('admin/tickets/answered') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'answered') }}">@lang("Answered Ticket")</a>
                            <a class="nav-link {{ request()->is('admin/tickets/replied') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'replied') }}">@lang("Replied Ticket")</a>
                            <a class="nav-link {{ request()->is('admin/tickets/closed') ? 'active' : '' }}"
                               href="{{ route('admin.ticket', 'closed') }}">@lang("Closed Ticket")</a>
                        </div>
                    </div>


                    <span class="dropdown-header mt-4"> @lang('Kyc Management')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.kyc.form.list']) }}"
                           href="{{ route('admin.kyc.form.list') }}" data-placement="left">
                            <i class="bi-stickies nav-icon"></i>
                            <span class="nav-link-title">@lang('KYC Setting')</span>
                        </a>
                    </div>

                    <div class="nav-item" {{ menuActive(['admin.kyc.list'], 3) }}>
                        <a class="nav-link dropdown-toggle collapsed" href="#navbarVerticalKycRequestMenu"
                           role="button"
                           data-bs-toggle="collapse" data-bs-target="#navbarVerticalKycRequestMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalKycRequestMenu">
                            <i class="bi bi-person-lines-fill nav-icon"></i>
                            <span class="nav-link-title">@lang("KYC Request")</span>
                        </a>
                        <div id="navbarVerticalKycRequestMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.kyc.list'], 2) }}"
                             data-bs-parent="#navbarVerticalKycRequestMenu">
                            <a class="nav-link {{ Request::is('admin/kyc/pending') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'pending') }}">
                                @lang('Pending KYC')
                            </a>
                            <a class="nav-link {{ Request::is('admin/kyc/approve') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'approve') }}">
                                @lang('Approved KYC')
                            </a>
                            <a class="nav-link {{ Request::is('admin/kyc/rejected') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'rejected') }}">
                                @lang('Rejected KYC')
                            </a>
                        </div>
                    </div>

                    <span class="dropdown-header mt-4"> @lang("User Panel")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>

                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.users'], 3) }}"
                           href="#navbarVerticalUserPanelMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalUserPanelMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalUserPanelMenu">
                            <i class="bi-people nav-icon"></i>
                            <span class="nav-link-title">@lang('User Management')</span>
                        </a>
                        <div id="navbarVerticalUserPanelMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.users'], 2) }}"
                             data-bs-parent="#navbarVerticalUserPanelMenu">
                            <a class="nav-link {{ menuActive(['admin.users']) }}" href="{{ route('admin.users') }}">
                                @lang('All User')
                            </a>
                            <a class="nav-link {{ menuActive(['admin.mail.all.user']) }}"
                               href="{{ route("admin.mail.all.user") }}">@lang('Mail To Users')</a>
                        </div>
                    </div>


                    <span class="dropdown-header mt-4"> @lang('SETTINGS PANEL')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.settings']) }}"
                           href="{{ route('admin.settings') }}" data-placement="left">
                            <i class="bi bi-gear nav-icon"></i>
                            <span class="nav-link-title">@lang('Control Panel')</span>
                        </a>
                    </div>

                    <div
                        class="nav-item {{ menuActive(['admin.payment.methods', 'admin.deposit.manual.index'], 3) }}">
                        <a class="nav-link dropdown-toggle"
                           href="#navbarVerticalGatewayMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalGatewayMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalGatewayMenu">
                            <i class="bi-briefcase nav-icon"></i>
                            <span class="nav-link-title">@lang('Payment Setting')</span>
                        </a>
                        <div id="navbarVerticalGatewayMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.payment.methods', 'admin.deposit.manual.index'], 2) }}"
                             data-bs-parent="#navbarVerticalGatewayMenu">
                            <a class="nav-link {{ menuActive(['admin.payment.methods']) }}"
                               href="{{ route('admin.payment.methods') }}">@lang('Payment Gateway')</a>
                            <a class="nav-link {{ menuActive(['admin.deposit.manual.index']) }}"
                               href="{{ route('admin.deposit.manual.index') }}">@lang('Manual Gateway')</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.payout.method.list', 'admin.payout.withdraw.days'], 3) }}"
                           href="#navbarVerticalWithdrawMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalWithdrawMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalWithdrawMenu">
                            <i class="bi bi-wallet2 nav-icon"></i>
                            <span class="nav-link-title">@lang('Withdraw Setting')</span>
                        </a>

                        <div id="navbarVerticalWithdrawMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.payout.method.list', 'admin.payout.withdraw.days'], 2) }}"
                             data-bs-parent="#navbarVerticalWithdrawMenu">
                            <a class="nav-link {{ menuActive(['admin.payout.method.list']) }}"
                               href="{{ route('admin.payout.method.list') }}">@lang('Withdraw Method')</a>

                            <a class="nav-link  {{ menuActive(['admin.payout.withdraw.days']) }}"
                               href="{{ route("admin.payout.withdraw.days") }}">@lang('Withdrawal Days Setup')</a>
                        </div>
                    </div>

                    <span class="dropdown-header mt-4">@lang("Themes Settings")</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div id="navbarVerticalThemeMenu">
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.page.index']) }}"
                               href="{{ route('admin.page.index', basicControl()->theme) }}"
                               data-placement="left">
                                <i class="fa-light fa-list nav-icon"></i>
                                <span class="nav-link-title">@lang('Pages')</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link" href="{{ route('admin.manage.menu') }}" data-placement="left">
                                <i class="bi-folder2-open nav-icon"></i>
                                <span class="nav-link-title">@lang('Manage Menu')</span>
                            </a>
                        </div>
                    </div>

                    @php
                        $segments = request()->segments();
                        $last  = end($segments);
                    @endphp
                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 3) }}"
                           href="#navbarVerticalContentsMenu"
                           role="button" data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalContentsMenu" aria-expanded="false"
                           aria-controls="navbarVerticalContentsMenu">
                            <i class="fa-light fa-section nav-icon"></i>
                            <span class="nav-link-title">@lang('Manage Content')</span>
                        </a>
                        <div id="navbarVerticalContentsMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 2) }}"
                             data-bs-parent="#navbarVerticalContentsMenu">
                            @foreach(array_diff(array_keys(config('contents')), ['message','content_media']) as $name)
                                <a class="nav-link {{($last == $name) ? 'active' : '' }}"
                                   href="{{ route('admin.manage.content', $name) }}">@lang(stringToTitle($name))</a>
                            @endforeach
                        </div>
                    </div>

                    @foreach(collect(config('generalsettings.settings')) as $key => $setting)
                        <div class="nav-item d-none">
                            <a class="nav-link  {{ isMenuActive($setting['route']) }}"
                               href="{{ getRoute($setting['route'], $setting['route_segment'] ?? null) }}">
                                <i class="{{$setting['icon']}} nav-icon"></i>
                                <span class="nav-link-title">{{ __(getTitle($key.' '.'Settings')) }}</span>
                            </a>
                        </div>
                    @endforeach


                </div>

                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">
                        <li class="navbar-vertical-footer-list-item">
                            <span class="dropdown-header">@lang('Version 1.0')</span>
                        </li>
                        <li class="navbar-vertical-footer-list-item">
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle"
                                        id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        data-bs-dropdown-animation></button>
                                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless"
                                     aria-labelledby="selectThemeDropdown">
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-moon-stars"
                                       data-value="auto">
                                        <i class="bi-moon-stars me-2"></i>
                                        <span class="text-truncate"
                                              title="Auto (system default)">@lang("Default")</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-brightness-high"
                                       data-value="default">
                                        <i class="bi-brightness-high me-2"></i>
                                        <span class="text-truncate"
                                              title="Default (light mode)">@lang("Light Mode")</span>
                                    </a>
                                    <a class="dropdown-item active" href="javascript:void(0)" data-icon="bi-moon"
                                       data-value="dark">
                                        <i class="bi-moon me-2"></i>
                                        <span class="text-truncate" title="Dark">@lang("Dark Mode")</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>




