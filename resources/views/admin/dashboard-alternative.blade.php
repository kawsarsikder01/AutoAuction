@extends('admin.layouts.app')
@section('page_title', __('Dashboard'))
@section('content')

    <!-- Content -->
    <div class="bg-dark">
        <div class="content container-fluid dashboard-height">
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">@lang("Dashboard")</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
    <div class="content container-fluid dashboard-margin-top">

        <div id="firebase-app">
            <div class="alert alert-soft-blue mb-4 mb-lg-7" role="alert"
                 v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="default">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="dark">
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <h3 class="alert-heading mb-1">@lang("Attention!")</h3>
                        <div class="d-flex align-items-center">
                            <p class="mb-0"> @lang('Please allow your browser to get instant push notification. Allow it from
                                notification setting.')</p>
                            <button id="allow-notification" class="btn btn-sm btn-primary mx-2"><i
                                    class="fa fa-check-circle"></i> @lang('Allow me')</button>
                        </div>
                    </div>
                    <button type="button" class="btn-close"
                            @click.prevent="skipNotification" data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            </div>
            <div class="alert alert-soft-blue mb-4 mb-lg-7" role="alert"
                 v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak>
                <div class="d-flex align-items-center mt-4">
                    <div class="flex-shrink-0">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="default">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="dark">
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <h3 class="alert-heading mb-1">@lang("Attention!")</h3>
                        <div class="d-flex align-items-center">
                            <p class="mb-0"> @lang("Please allow your browser to get instant push notification. Allow it from
                                notification setting.")</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" @click.prevent="skipNotification" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">@lang("Recent Transaction")</h4>

                <!-- Nav -->
                <ul class="nav nav-segment nav-fill" id="projectsTab" role="tablist">
                    <li class="nav-item this-month" data-bs-toggle="chart" data-datasets="0" data-trigger="click"
                        data-action="toggle">
                        <a class="nav-link active" href="javascript:void(0);"
                           data-bs-toggle="tab">@lang("This Month")</a>
                    </li>
                    <li class="nav-item" data-bs-toggle="chart" data-datasets="1" data-trigger="click"
                        data-action="toggle">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="tab">@lang("Last Month")</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-sm-center mb-4">
                    <div class="col-sm mb-3 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <span class="h5 mb-0"> @lang("DEPOSIT:") <span class="deposit_amount"></span> </span>
                        </div>

                        <div class="d-flex align-items-center">
                            <span class="h5 mb-0"> @lang("WITHDRAW:") <span class="withdraw_amount"></span> </span>
                        </div>

                    </div>
                    <!-- End Col -->
                    <div class="col-sm-auto">
                        <!-- Legend Indicators -->
                        <div class="row fs-6">
                            <div class="col-auto">
                                <span class="legend-indicator bg-primary"></span> @lang("Deposit")
                            </div>
                            <div class="col-auto">
                                <span class="legend-indicator bg-info"></span> @lang("Withdraw")
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->

                <!-- Bar Chart -->
                <div class="chartjs-custom chartjs-height">
                    <canvas id="updatingLineChart" data-hs-chartjs-options='{
                      "type": "line",
                      "data": {
                         "labels": @json($statistics['schedule']->keys()),
                         "datasets": [{
                          "backgroundColor": ["rgba(55,125,255, .5)", "rgba(255, 255, 255, .2)"],
                          "borderColor": "#377dff",
                          "borderWidth": 2,
                          "pointRadius": 0,
                          "hoverBorderColor": "#377dff",
                          "pointBackgroundColor": "#377dff",
                          "pointBorderColor": "#fff",
                          "pointHoverRadius": 0,
                          "tension": 0.4
                        },
                        {
                          "backgroundColor": ["rgba(0, 201, 219, .5)", "rgba(255, 255, 255, .2)"],
                          "borderColor": "#00c9db",
                          "borderWidth": 2,
                          "pointRadius": 0,
                          "hoverBorderColor": "#00c9db",
                          "pointBackgroundColor": "#00c9db",
                          "pointBorderColor": "#fff",
                          "pointHoverRadius": 0,
                          "tension": 0.4
                        }]
                      },
                      "options": {
                        "gradientPosition": {"y1": 200},
                         "scales": {
                            "y": {
                              "grid": {
                                "color": "#e7eaf3",
                                "drawBorder": false,
                                "zeroLineColor": "#e7eaf3"
                              },
                              "ticks": {
                                "min": 0,
                                "max": 100,
                                "stepSize": 100,
                                "fontColor": "#97a4af",
                                "fontFamily": "Open Sans, sans-serif",
                                "padding": 10,
                                "postfix": "k"
                              }
                            },
                            "x": {
                              "grid": {
                                "display": false,
                                "drawBorder": false
                              },
                              "ticks": {
                                "fontSize": 12,
                                "fontColor": "#97a4af",
                                "fontFamily": "Open Sans, sans-serif",
                                "padding": 5
                              }
                            }
                        },
                        "plugins": {
                          "tooltip": {
                            "prefix": "{{ basicControl()->currency_symbol }}",
                            "hasIndicator": true,
                            "mode": "index",
                            "intersect": false,
                            "lineMode": true,
                            "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                          }
                        },
                        "hover": {
                          "mode": "nearest",
                          "intersect": true
                        }
                      }
                    }'>
                    </canvas>
                </div>
            </div>
        </div>
        <!-- End Card -->


        <!-- Stats -->
        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="{{route('admin.users')}}">
                    <div class="card-body">
                        <h6 class="card-subtitle">Total Users</h6>

                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <h2 class="card-title text-inherit">{{fractionNumber($userRecord['totalUsers'], false)}}</h2>
                            </div>
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom chartjs-line-height">
                                    <canvas class="js-chart" data-hs-chartjs-options='{
                                      "type": "line",
                                      "data": {
                                         "labels": @json($userRecord['current_month_data']->pluck('date')),
                                         "datasets": [{
                                          "data": @json($userRecord['current_month_data']->pluck('count')),
                                          "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                          "borderColor": "#377dff",
                                          "borderWidth": 2,
                                          "pointRadius": 0,
                                          "pointHoverRadius": 0
                                        }]
                                      },
                                      "options": {
                                         "scales": {
                                           "y": {
                                             "display": false
                                           },
                                           "x": {
                                             "display": false
                                           }
                                         },
                                        "hover": {
                                          "mode": "nearest",
                                          "intersect": false
                                        },
                                        "plugins": {
                                          "tooltip": {
                                            "postfix": "",
                                            "hasIndicator": true,
                                            "intersect": false
                                          }
                                        }
                                      }
                                    }'>
                                    </canvas>
                                </div>
                            </div>
                        </div>
                        <span class="badge {{$userRecord['followupGrapClass']}}">
                        <i class="bi-graph-up"></i> {{$userRecord['followupGrap']}}%
                      </span>
                        <span class="text-body fs-6 ms-1">from {{fractionNumber($userRecord['totalUsers']-$userRecord['currentDateUserCount'], false)}}</span>
                    </div>
                </a>
            </div>



            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <a class="card card-hover-shadow h-100" href="{{ route("admin.ticket", 'tickets') }}">
                    <div class="card-body">
                        <h6 class="card-subtitle">@lang("Pending Tickets")</h6>
                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <h2 class="card-title text-inherit">{{fractionNumber($supportTicket['pending'], false)}}</h2>
                            </div>
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom chartjs-line-height">
                                    <canvas class="js-chart" data-hs-chartjs-options='{
                                  "type": "line",
                                  "data": {
                                     "labels": @json($supportTicket['current_month_data']->pluck('date')),
                                     "datasets": [{
                                      "data": @json($supportTicket['current_month_data']->pluck('count')),
                                      "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                      "borderColor": "#377dff",
                                      "borderWidth": 2,
                                      "pointRadius": 0,
                                      "pointHoverRadius": 0
                                    }]
                                  },
                                  "options": {
                                     "scales": {
                                       "y": {
                                         "display": false
                                       },
                                       "x": {
                                         "display": false
                                       }
                                     },
                                    "hover": {
                                      "mode": "nearest",
                                      "intersect": false
                                    },
                                    "plugins": {
                                      "tooltip": {
                                        "postfix": "",
                                        "hasIndicator": true,
                                        "intersect": false
                                      }
                                    }
                                  }
                                }'>
                                    </canvas>
                                </div>
                            </div>
                        </div>
                        <span class="badge {{$supportTicket['followupGrapClass']}}">
                        <i class="bi-graph-up"></i> {{$supportTicket['followupGrap']}}%
                      </span>
                        <span class="text-body fs-6 ms-1">from {{fractionNumber($supportTicket['totalTickets'], false)}}</span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <!-- Card -->
                <a class="card card-hover-shadow h-100" href="{{ route("admin.kyc.list") }}">
                    <div class="card-body">
                        <h6 class="card-subtitle">@lang("Pending KYC")</h6>
                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <h2 class="card-title text-inherit">{{fractionNumber($kycRecords['pendingKYC'], false)}}</h2>
                            </div>
                            <div class="col-6">
                                <!-- Chart -->
                                <div class="chartjs-custom chartjs-line-height">
                                    <canvas class="js-chart" data-hs-chartjs-options='{
                                      "type": "line",
                                      "data": {
                                         "labels": @json($kycRecords['current_month_data']->pluck('date')),
                                         "datasets": [{
                                          "data": @json($kycRecords['current_month_data']->pluck('count')),
                                          "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                          "borderColor": "#377dff",
                                          "borderWidth": 2,
                                          "pointRadius": 0,
                                          "pointHoverRadius": 0
                                        }]
                                      },
                                      "options": {
                                         "scales": {
                                           "y": {
                                             "display": false
                                           },
                                           "x": {
                                             "display": false
                                           }
                                         },
                                        "hover": {
                                          "mode": "nearest",
                                          "intersect": false
                                        },
                                        "plugins": {
                                          "tooltip": {
                                            "postfix": "k",
                                            "hasIndicator": true,
                                            "intersect": false
                                          }
                                        }
                                      }
                                    }'>
                                    </canvas>
                                </div>
                                <!-- End Chart -->
                            </div>
                        </div>
                        <span class="badge {{$kycRecords['followupGrapClass']}}">
                        <i class="bi-graph-up"></i> {{$kycRecords['followupGrap']}}%
                      </span>
                        <span class="text-body fs-6 ms-1">from {{fractionNumber($kycRecords['totalKYC'], false)}}</span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <a class="card card-hover-shadow h-100" href="{{ route("admin.transaction") }}">
                    <div class="card-body">
                        <h6 class="card-subtitle">@lang("This Month Transactions")</h6>
                        <div class="row align-items-center gx-2 mb-1">
                            <div class="col-6">
                                <h2 class="card-title text-inherit">{{fractionNumber($transaction['totalTransaction'], false)}}</h2>
                            </div>
                            <div class="col-6">
                                <div class="chartjs-custom chartjs-line-height">
                                    <canvas class="js-chart" data-hs-chartjs-options='{
                                      "type": "line",
                                      "data": {
                                         "labels": @json($transaction['current_month_data']->pluck('date')),
                                         "datasets": [{
                                          "data": @json($transaction['current_month_data']->pluck('count')),
                                          "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                                          "borderColor": "#377dff",
                                          "borderWidth": 2,
                                          "pointRadius": 0,
                                          "pointHoverRadius": 0
                                        }]
                                      },
                                      "options": {
                                         "scales": {
                                           "y": {
                                             "display": false
                                           },
                                           "x": {
                                             "display": false
                                           }
                                         },
                                        "hover": {
                                          "mode": "nearest",
                                          "intersect": false
                                        },
                                        "plugins": {
                                          "tooltip": {
                                            "postfix": "",
                                            "hasIndicator": true,
                                            "intersect": false
                                          }
                                        }
                                      }
                                    }'>
                                    </canvas>
                                </div>
                            </div>
                        </div>
                        <span class="badge {{$transaction['followupGrapClass']}}">
                        <i class="bi-graph-up"></i> {{$transaction['followupGrap']}}%
                      </span>
                        <span class="text-body fs-6 ms-1">from {{fractionNumber($transaction['totalTransaction'], false)}}</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Sales <i class="bi-question-circle text-body ms-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Net sales (gross sales minus discounts and returns) plus taxes and shipping. Includes orders from all sales channels."></i>
                </h4>


            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <div class="row col-lg-divider">
                    <div class="col-lg-9 mb-5 mb-lg-0">
                        <!-- Bar Chart -->
                        <div class="chartjs-custom mb-4">
                            <canvas id="ecommerce-sales" class="js-chart sales-chart-height"
                                    data-hs-chartjs-options='{
                          "type": "bar",
                          "data": {
                            "labels": ["1AM","2AM","3AM","4AM","5AM","6AM","7AM","8AM","9AM","10AM","11AM"],
                            "datasets": [{
                              "data": [200, 300, 290, 350, 150, 350, 300, 100, 125, 220, 200, 300, 290, 350, 150, 350, 300, 100, 125, 220, 225],
                              "backgroundColor": "#377dff",
                              "hoverBackgroundColor": "#377dff",
                              "borderColor": "#377dff",
                              "maxBarThickness": "10"
                            },
                            {
                              "data": [150, 230, 382, 204, 169, 290, 300, 100, 300, 225, 120, 150, 230, 382, 204, 169, 290, 300, 100, 300, 140],
                              "backgroundColor": "#e7eaf3",
                              "borderColor": "#e7eaf3",
                              "maxBarThickness": "10"
                            }]
                          },
                          "options": {
                            "scales": {
                              "y": {
                                "grid": {
                                  "color": "#e7eaf3",
                                  "drawBorder": false,
                                  "zeroLineColor": "#e7eaf3"
                                },
                                "ticks": {
                                  "beginAtZero": true,
                                  "stepSize": 100,
                                  "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                  "padding": 10
                                }
                              },
                              "x": {
                                "grid": {
                                  "display": false,
                                  "drawBorder": false
                                },
                                "ticks": {
                                  "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                  "padding": 5
                                },
                                "categoryPercentage": 0.5,
                                "maxBarThickness": "10"
                              }
                            },
                            "cornerRadius": 2,
                            "plugins": {
                              "tooltip": {
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false
                              }
                            },
                            "hover": {
                              "mode": "nearest",
                              "intersect": true
                            }
                          }
                        }'></canvas>
                        </div>
                        <!-- End Bar Chart -->

                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <span class="legend-indicator"></span> Revenue
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <span class="legend-indicator bg-primary"></span> Orders
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-sm-6 col-lg-12">
                                <!-- Stats -->
                                <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                                    <h6 class="card-subtitle">Revenue</h6>
                                    <span class="d-block display-4 text-dark mb-1 me-3">$97,458.20</span>
                                    <span class="d-block text-success">
                      <i class="bi-graph-up me-1"></i> $2,401.02 (3.7%)
                    </span>
                                </div>
                                <!-- End Stats -->

                                <hr class="d-none d-lg-block my-0">
                            </div>
                            <!-- End Col -->

                            <div class="col-sm-6 col-lg-12">
                                <!-- Stats -->
                                <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                                    <h6 class="card-subtitle">Orders</h6>
                                    <span class="d-block display-4 text-dark mb-1 me-3">67,893</span>
                                    <span class="d-block text-danger">
                      <i class="bi-graph-down me-1"></i> +3,301 (1.2%)
                    </span>
                                </div>
                                <!-- End Stats -->
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="row col-lg-divider">
                <div class="col-lg-6">
                    <!-- Body -->
                    <div class="card-body">
                        <h4>Total Orders <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Net sales (gross sales minus discounts and returns) plus taxes and shipping. Includes orders from all sales channels."></i>
                        </h4>

                        <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
                            <div class="col-sm mb-3 mb-sm-0">
                                <span class="display-5 text-dark me-2">$597,820.75</span>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm-auto">
                  <span class="h3 text-success">
                    <i class="bi-graph-up"></i> 25.9%
                  </span>
                                <span class="d-block">&mdash; 1,347,935 orders <span
                                        class="badge bg-soft-dark text-dark rounded-pill ms-1">+$97k today</span></span>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                        <!-- Bar Chart -->
                        <div class="chartjs-custom mb-4 bar-chart-height">
                            <canvas id="ecommerce-overview-1" class="js-chart" data-hs-chartjs-options='{
                          "type": "line",
                          "data": {
                             "labels": ["1AM","2AM","3AM","4AM","5AM","6AM","7AM","8AM","9AM","10AM"],
                             "datasets": [{
                              "data": [200, 200, 240, 350, 200, 350, 200, 250, 285, 220],
                              "backgroundColor": "transparent",
                              "borderColor": "#377dff",
                              "borderWidth": 2,
                              "pointRadius": 0,
                              "hoverBorderColor": "#377dff",
                              "pointBackgroundColor": "#377dff",
                              "pointBorderColor": "#fff",
                              "pointHoverRadius": 0,
                              "tension": 0.4
                            },
                            {
                              "data": [150, 230, 382, 204, 269, 290, 200, 250, 200, 225],
                              "backgroundColor": "transparent",
                              "borderColor": "#e7eaf3",
                              "borderWidth": 2,
                              "pointRadius": 0,
                              "hoverBorderColor": "#e7eaf3",
                              "pointBackgroundColor": "#e7eaf3",
                              "pointBorderColor": "#fff",
                              "pointHoverRadius": 0,
                              "tension": 0.4
                            }]
                          },
                          "options": {
                             "scales": {
                                "y": {
                                  "grid": {
                                    "color": "#e7eaf3",
                                    "drawBorder": false,
                                    "zeroLineColor": "#e7eaf3"
                                  },
                                  "ticks": {
                                    "beginAtZero": true,
                                    "stepSize": 100,
                                    "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                    "padding": 10,
                                    "prefix": "$",
                                    "postfix": "k"
                                  }
                                },
                                "x": {
                                  "grid": {
                                    "display": false,
                                    "drawBorder": false
                                  },
                                  "ticks": {
                                    "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                    "padding": 5
                                  }
                                }
                            },
                            "plugins": {
                              "tooltip": {
                                "prefix": "$",
                                "postfix": "k",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false,
                                "lineMode": true,
                                "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                              }
                            },
                            "hover": {
                              "mode": "nearest",
                              "intersect": true
                            }
                          }
                        }'>
                            </canvas>
                        </div>
                        <!-- End Bar Chart -->

                        <!-- Legend Indicators -->
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <span class="legend-indicator"></span> Yesterday
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <span class="legend-indicator bg-primary"></span> Today
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Legend Indicators -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Col -->

                <div class="col-lg-6">
                    <!-- Body -->
                    <div class="card-body">
                        <h4>Visitors</h4>

                        <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
                            <div class="col-sm mb-3 mb-sm-0">
                                <span class="display-5 text-dark me-2">831,071</span>
                            </div>
                            <!-- End Col -->
                            <div class="col-sm-auto">
                              <span class="h3 text-danger">
                                <i class="bi-graph-down"></i> 16%
                              </span>
                                <span class="d-block">&mdash; 467,001 unique <span
                                        class="badge bg-soft-dark text-dark rounded-pill ms-1">+7k today</span></span>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                        <!-- Bar Chart -->
                        <div class="chartjs-custom mb-4 bar-chart-height">
                            <canvas id="ecommerce-overview-2" class="js-chart" data-hs-chartjs-options='{
                          "type": "line",
                          "data": {
                             "labels": ["1AM","2AM","3AM","4AM","5AM","6AM","7AM","8AM","9AM","10AM"],
                             "datasets": [{
                              "data": [20, 20, 24, 15, 30, 35, 20, 28, 18, 16],
                              "backgroundColor": "transparent",
                              "borderColor": "#377dff",
                              "borderWidth": 2,
                              "pointRadius": 0,
                              "hoverBorderColor": "#377dff",
                              "pointBackgroundColor": "#377dff",
                              "pointBorderColor": "#fff",
                              "pointHoverRadius": 0,
                              "tension": 0.4
                            },
                            {
                              "data": [15, 23, 18, 20, 36, 29, 20, 22, 20, 22],
                              "backgroundColor": "transparent",
                              "borderColor": "#e7eaf3",
                              "borderWidth": 2,
                              "pointRadius": 0,
                              "hoverBorderColor": "#e7eaf3",
                              "pointBackgroundColor": "#e7eaf3",
                              "pointBorderColor": "#fff",
                              "pointHoverRadius": 0,
                              "tension": 0.4
                            }]
                          },
                          "options": {
                             "scales": {
                                "y": {
                                  "grid": {
                                    "color": "#e7eaf3",
                                    "drawBorder": false,
                                    "zeroLineColor": "#e7eaf3"
                                  },
                                  "ticks": {
                                    "beginAtZero": true,
                                    "stepSize": 10,
                                    "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                    "padding": 10,
                                    "postfix": "k"
                                  }
                                },
                                "x": {
                                  "grid": {
                                    "display": false,
                                    "drawBorder": false
                                  },
                                  "ticks": {
                                    "color": "#97a4af",
                                    "font": {
                                      "size": 12,
                                      "family": "Open Sans, sans-serif"
                                    },
                                    "padding": 5
                                  }
                                }
                            },
                            "plugins": {
                              "tooltip": {
                                "postfix": "k",
                                "hasIndicator": true,
                                "mode": "index",
                                "intersect": false,
                                "lineMode": true,
                                "lineWithLineColor": "rgba(19, 33, 68, 0.075)"
                              }
                            },
                            "hover": {
                              "mode": "nearest",
                              "intersect": true
                            }
                          }
                        }'>
                            </canvas>
                        </div>
                        <!-- End Bar Chart -->

                        <!-- Legend Indicators -->
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <span class="legend-indicator"></span> Yesterday
                            </div>
                            <!-- End Col -->

                            <div class="col-auto">
                                <span class="legend-indicator bg-primary"></span> Today
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Legend Indicators -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Card -->


        <div class="card mb-3 mb-lg-5">
            <div class="card-header card-header-content-between">
                <h4 class="card-header-title">@lang("Latest Users")</h4>

                <a class="btn btn-ghost-secondary btn-sm" href="{{ route("admin.users") }}">@lang("View All")</a>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>@lang('Full Name')</th>
                        <th>@lang('Email-Phone')</th>
                        <th>@lang('Balance')</th>
                        <th>@lang('Country')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Last Login')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($latestUser as $user)
                        <tr>
                            <td>

                                <a class="d-flex align-items-center me-2"
                                   href="{{ route("admin.user.view.profile", $user->id) }}">
                                    <div class="flex-shrink-0">
                                        {!! $user->profilePicture() !!}
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="text-hover-primary mb-0">{{ $user->firstname . ' ' . $user->lastname }}</h5>
                                        <span class="fs-6 text-body">{{'@'. $user->username }}</span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <span class="d-block h5 mb-0"> {{ $user->email }}</span>
                                <span class="d-block fs-5">{{ $user->phone }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ currencyPosition($user->balance) }}
                                </div>
                            </td>
                            <td>
                                {{ $user->country ?? 'N/A' }}
                            </td>
                            <td>
                                @if($user->status == 1)
                                    <span class="badge bg-soft-success text-success">
                                        <span class="legend-indicator bg-success"></span>@lang("Active")
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger">
                                        <span class="legend-indicator bg-danger"></span>@lang("Inactive")
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ diffForHumans($user->last_login) }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-white btn-sm" href="{{ route('admin.user.edit', $user->id) }}">
                                        <i class="bi-pencil-fill me-1"></i> @lang("Edit")
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown" >
                                            <a class="dropdown-item" href="{{ route('admin.user.view.profile', $user->id) }}">
                                                <i class="bi-eye-fill dropdown-item-icon"></i> @lang("View Profile")
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.send.email', $user->id) }}"> <i
                                                    class="bi-envelope dropdown-item-icon"></i> @lang("Send Mail") </a>
                                            <a class="dropdown-item loginAccount" href="javascript:void(0)"
                                               data-route="{{ route('admin.login.as.user', $user->id) }}"
                                               data-bs-toggle="modal" data-bs-target="#loginAsUserModal">
                                                <i class="bi bi-box-arrow-in-right dropdown-item-icon"></i>
                                                @lang("Login As User")
                                            </a>
                                            <a class="dropdown-item addBalance" href="javascript:void(0)"
                                               data-route="{{ route('admin.user.update.balance', $user->id) }}"
                                               data-balance="{{ currencyPosition($user->balance) }}"
                                               data-bs-toggle="modal" data-bs-target="#addBalanceModal">
                                                <i class="bi bi-cash-coin dropdown-item-icon"></i>
                                                @lang("Manage Balance")
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <div class="text-center p-4">
                                <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                                <p class="mb-0">@lang("No data to show")</p>
                            </div>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="card-header-title">@lang("Browser History")</h4>
                    </div>
                    <!-- Body -->
                    <div class="card-body text-center">
                        <div class="h3">
                            <span class="badge bg-soft-info text-info rounded-pill">
                              <i class="bi-check-circle-fill me-1"></i> @lang("On track")
                            </span>
                        </div>

                        <!-- Chart Half -->
                        <!-- Pie Chart -->
                        <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
                            <canvas id="doughnut-chart" class="js-chart"
                                    data-hs-chartjs-options='{
                                      "type": "doughnut",
                                      "data": {
                                        "labels": @json($userLoginsBrowserData->keys()),
                                        "datasets": [{
                                          "data": @json($userLoginsBrowserData->values()),
                                          "backgroundColor": [ "#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"],
                                           "borderWidth": 0.5,
                                          "hoverBorderColor": "#fff"
                                        }]
                                      },
                                      "options": {
                                        "cutout": "70%",
                                        "plugins": {
                                          "tooltip": {
                                            "hasIndicator": true,
                                            "mode": "index",
                                            "intersect": false
                                          }
                                        },
                                        "hover": {
                                          "mode": "nearest",
                                          "intersect": true
                                        }
                                      }
                                    }'>
                            </canvas>
                        </div>
                        <!-- End Pie Chart -->
                        <hr>
                        <div class="row col-divider">
                            <div class="col text-center">
                                <span class="d-block">@lang("Last 30 Days Browser History")</span>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
            <div class="col-lg-4 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="card-header-title">@lang("Operating System History")</h4>
                    </div>
                    <!-- Body -->
                    <div class="card-body text-center">
                        <div class="h3">
                            <span class="badge bg-soft-info text-info rounded-pill">
                              <i class="bi-check-circle-fill me-1"></i> @lang("On track")
                            </span>
                        </div>

                        <!-- Chart Half -->
                        <!-- Pie Chart -->
                        <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
                            <canvas id="doughnut-chart" class="js-chart"
                                    data-hs-chartjs-options='{
                                  "type": "doughnut",
                                  "data": {
                                    "labels": @json($userLoginsOSData->keys()),
                                    "datasets": [{
                                      "data": @json($userLoginsOSData->values()),
                                      "backgroundColor": [ "#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"],
                                      "borderWidth": 0.5,
                                      "hoverBorderColor": "#fff"
                                    }]
                                  },
                                  "options": {
                                    "cutout": "70%",
                                    "plugins": {
                                      "tooltip": {
                                        "hasIndicator": true,
                                        "mode": "index",
                                        "intersect": false
                                      }
                                    },
                                    "hover": {
                                      "mode": "nearest",
                                      "intersect": true
                                    }
                                  }
                                }'>
                            </canvas>
                        </div>
                        <!-- End Pie Chart -->

                        <hr>

                        <div class="row col-divider">
                            <div class="col text-center">
                                <span class="d-block">@lang("Last 30 Days OS History")</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <div class="col-lg-4 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="card-header-title">@lang("Device History")</h4>
                    </div>
                    <!-- Body -->
                    <div class="card-body text-center">
                        <div class="h3">
                            <span class="badge bg-soft-info text-info rounded-pill">
                              <i class="bi-check-circle-fill me-1"></i> @lang("On track")
                            </span>
                        </div>
                        <!-- Pie Chart -->
                        <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
                            <canvas id="doughnut-chart" class="js-chart"
                                    data-hs-chartjs-options='{
                                  "type": "doughnut",
                                  "data": {
                                    "labels": @json($userLoginsDeviceData->keys()),
                                    "datasets": [{
                                      "data": @json($userLoginsDeviceData->values()),
                                      "backgroundColor": [ "#0072C6","#FF9500","#FF5733"],
                                      "borderWidth": 0.5,
                                      "hoverBorderColor": "#fff"
                                    }]
                                  },
                                  "options": {
                                    "cutout": "70%",
                                    "plugins": {
                                      "tooltip": {
                                        "hasIndicator": true,
                                        "mode": "index",
                                        "intersect": false
                                      }
                                    },
                                    "hover": {
                                      "mode": "nearest",
                                      "intersect": true
                                    }
                                  }
                                }'>
                            </canvas>
                        </div>
                        <!-- End Pie Chart -->

                        <hr>

                        <div class="row col-divider">
                            <div class="col text-center">
                                <span class="d-block">@lang("Last 30 Days Device History")</span>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

    @include('admin.user_management.components.login_as_user')
    @include('admin.user_management.components.update_balance_modal')

@endsection

@push('js-lib')
    <script src="{{ asset('assets/admin/js/Chart.min.js') }}"></script>
@endpush

@push("script")
    <script>

        $(document).on('click', '.loginAccount', function () {
            let route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });

        $(document).on('click', '.addBalance', function (){
            $('.setBalanceRoute').attr('action', $(this).data('route'));
            $('.user-balance').text($(this).data('balance'));
        })

        document.querySelectorAll('.js-chart').forEach(item => {
            HSCore.components.HSChartJS.init(item)
        })


        var $monthlyDeposit = 0;
        var $monthlyWithdraw = 0;

        var $totalDeposit = {};
        var $totalWithdraw = {};

        function monthlyDepositWithdraw(keyDataset = 0) {
            $.ajax({
                url: "{{ route('admin.monthly.deposit.withdraw') }}",
                data: {
                    keyDataset
                },
                dataType: 'json',
                type: "GET",
                success: function (data) {
                    $totalDeposit[keyDataset] = data.dailyDeposit;
                    $totalWithdraw[keyDataset] = data.dailyWithdraw;

                    $monthlyDeposit = data.totalDeposit
                    $monthlyWithdraw = data.totalWithdraw;

                    $(".deposit_amount").text($monthlyDeposit);
                    $(".withdraw_amount").text($monthlyDeposit);

                    updateChart(keyDataset);
                },
                async: false // Note that synchronous AJAX is deprecated and not recommended
            });
        }

        const updatingChartDatasets = [
            [$totalDeposit[0], $totalWithdraw[0]],
            [$totalDeposit[1], $totalWithdraw[1]]
        ];

        HSCore.components.HSChartJS.init(document.querySelector('#updatingLineChart'), {
            data: {
                datasets: [
                    {
                        data: updatingChartDatasets[0][0]
                    },
                    {
                        data: updatingChartDatasets[0][1]
                    }
                ]
            }
        });

        const updatingLineChart = HSCore.components.HSChartJS.getItem('updatingLineChart');

        // Function to update the chart
        function updateChart(keyDataset) {
            updatingChartDatasets[keyDataset] = [$totalDeposit[keyDataset], $totalWithdraw[keyDataset]];

            updatingLineChart.data.datasets.forEach(function (dataset, key) {
                dataset.data = updatingChartDatasets[keyDataset][key];
            });

            updatingLineChart.update();
        }

        // Call when tab is clicked
        document.querySelectorAll('[data-bs-toggle="chart"]').forEach(item => {
            item.addEventListener('click', e => {
                let keyDataset = e.currentTarget.getAttribute('data-datasets');
                monthlyDepositWithdraw(keyDataset);
            });
        });

        // Initial rendering of the chart with the first dataset
        monthlyDepositWithdraw(0);


    </script>
@endpush

@if($firebaseNotify)
    @push('script')
        <script type="module">

            import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
            import {
                getMessaging,
                getToken,
                onMessage
            } from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

            const firebaseConfig = {
                apiKey: "{{$firebaseNotify['apiKey']}}",
                authDomain: "{{$firebaseNotify['authDomain']}}",
                projectId: "{{$firebaseNotify['projectId']}}",
                storageBucket: "{{$firebaseNotify['storageBucket']}}",
                messagingSenderId: "{{$firebaseNotify['messagingSenderId']}}",
                appId: "{{$firebaseNotify['appId']}}",
                measurementId: "{{$firebaseNotify['measurementId']}}"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{ getProjectDirectory() }}' + `/firebase-messaging-sw.js`, {scope: './'}).then(function (registration) {
                        requestPermissionAndGenerateToken(registration);
                    }
                ).catch(function (error) {
                });
            } else {
            }

            onMessage(messaging, (payload) => {
                if (payload.data.foreground || parseInt(payload.data.foreground) == 1) {
                    const title = payload.notification.title;
                    const options = {
                        body: payload.notification.body,
                        icon: payload.notification.icon,
                    };
                    new Notification(title, options);
                }
            });

            function requestPermissionAndGenerateToken(registration) {
                document.addEventListener("click", function (event) {
                    if (event.target.id == 'allow-notification') {
                        Notification.requestPermission().then((permission) => {
                            if (permission === 'granted') {
                                getToken(messaging, {
                                    serviceWorkerRegistration: registration,
                                    vapidKey: "{{$firebaseNotify['vapidKey']}}"
                                })
                                    .then((token) => {
                                        $.ajax({
                                            url: "{{ route('admin.save.token') }}",
                                            method: "post",
                                            data: {
                                                token: token,
                                            },
                                            success: function (res) {
                                            }
                                        });
                                        window.newApp.notificationPermission = 'granted';
                                    });
                            } else {
                                window.newApp.notificationPermission = 'denied';
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            window.newApp = new Vue({
                el: "#firebase-app",
                data: {
                    admin_foreground: '',
                    admin_background: '',
                    notificationPermission: Notification.permission,
                    is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
                },
                mounted() {
                    sessionStorage.clear();
                    this.admin_foreground = "{{$firebaseNotify['admin_foreground']}}";
                    this.admin_background = "{{$firebaseNotify['admin_background']}}";
                },
                methods: {
                    skipNotification() {
                        sessionStorage.setItem('is_notification_skipped', '1');
                        this.is_notification_skipped = true;
                    }
                }
            });
        </script>
    @endpush
@endif













