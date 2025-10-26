@extends($theme.'layouts.user')
@section('title',trans('Auction Visitors'))
@section('content')
    <div class="container-fluid">
        <div class="main row g-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-6" id="AuctionVisitorsCard">
                        <div class="card rounded-4 ">
                            <div class="card-header bg-white">
                                <h4 class="card-header-title mt-3">
                                    @lang('Auction Visitors')
                                </h4>
                            </div>
                            <div class="card-body mt-0">
                                <canvas id="Visitor"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card rounded-4">
                            <div class="card-header bg-white">
                                <h4 class="card-header-title">@lang('Top Bidders')</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>@lang('No')</th>
                                        <th>@lang('Bidder')</th>
                                        <th>@lang('Bid Amount')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topbidders as $key=> $item)
                                        <tr>
                                            <td data-label="@lang('No')">{{$key+1}}</td>
                                            <td data-label="@lang('Bidder')">
                                                <div class="d-flex">
                                                    <div class="img">
                                                        <img
                                                            src="{{getFile($item->bidder->image_driver,$item->bidder->image)}}"
                                                            class="bidderProfileImage" alt=""/>
                                                    </div>
                                                    <div class="text-box ms-2">
                                                        <span
                                                            class="">{{$item->bidder->firstname." ".$item->bidder->lastname}}</span>
                                                        <p class=""
                                                           style="text-transform: lowercase">{{'@'.strtolower($item->bidder->username)}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="@lang('Bid Amount')">{{currencyPosition($item->bid_amount)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
                        <div class="card custom-chart" id="DeviceCard">
                            <div class="card-header bg-white">
                                <h4 class="card-header-title d-block m-auto p-1">
                                    @lang('Visitors Device History')
                                </h4>
                            </div>
                            <div class="card-body  " >
                                <canvas id="GetDeviceHistory" ></canvas>
                            </div>
                            <div class="card-footer bg-white">
                                <span class="d-block text-center">@lang("Last 30 Days Device History")</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
                        <div class="card custom-chart" id="BrowserCard">
                            <div class="card-header bg-white ">
                                <h4 class="card-header-title d-block m-auto p-1">
                                    @lang('Visitors Browser History')
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="GetBrowserHistory" ></canvas>
                            </div>
                            <div class="card-footer bg-white">
                                <span class="d-block text-center">@lang("Last 30 Days Device History")</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
                        <div class="card  custom-chart" id="OperatingSystemCard">
                            <div class="card-header bg-white">
                                <h4 class="card-header-title d-block m-auto p-1">
                                    @lang('Visitors OS History')
                                </h4>
                            </div>
                            <div class="card-body ">
                                <canvas id="GetOperatingSystemHistory"></canvas>
                            </div>
                            <div class="card-footer bg-white">
                                <span class="d-block text-center">@lang("Last 30 Days Device History")</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js-lib')
    <script src="{{ asset('assets/admin/js/chart.min.js') }}"></script>
@endpush
@push('script')
    <script>
        Notiflix.Block.standard('#AuctionVisitorsCard')
        const auctionVisitors = new Chart("Visitor", {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    label: "Current Month",
                    borderColor: "#00cec9",
                    fill: false
                },
                    {
                        data: [],
                        label: "Last Month",
                        borderColor: "#e7eaf3",
                        fill: false
                    }]
            },
            options: {
                scales: {
                    legend: {display: true},
                    y: {
                        grid: {
                            color: "#e7eaf3",
                            drawBorder: false,
                            zeroLineColor: "#e7eaf3"
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 10,
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 1,
                            postfix: ""
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                        }
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            }
        });

        Notiflix.Block.standard('#DeviceCard')
        const deviceHistory =   new Chart("GetDeviceHistory", {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    backgroundColor: [ "#0072C6","#FF9500","#FF5733"],
                    data: []
                }]
            },
            options: {
                cutout: '70%',
                title: {
                    display: true,
                },
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: 'index',
                        intersect: false
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });
        Notiflix.Block.standard('#BrowserCard');
        const getBrowserHistory = new Chart("GetBrowserHistory", {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    backgroundColor: [ "#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"],
                    data: []
                }]
            },
            options: {
                cutout: '70%',
                title: {
                    display: true,
                },
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: 'index',
                        intersect: false
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });
        Notiflix.Block.standard('#OperatingSystemCard');
        const getOperatinSystem =   new Chart("GetOperatingSystemHistory", {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    backgroundColor: [ "#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"],
                    data: []
                }]
            },
            options: {
                cutout: '70%',
                title: {
                    display: true,
                },
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: 'index',
                        intersect: false
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });

        getVistors()
        getVisitorsHistory()
        async function getVistors() {
            let url = "{{route('user.auction.visitors',$auction_id)}}"
            await axios.get(url)
                .then(function (res) {
                    auctionVisitors.config.data.labels = res.data.labels;
                    auctionVisitors.config.data.datasets[0].data = res.data.currentMonthVisitors;
                    auctionVisitors.config.data.datasets[1].data = res.data.lastMonthVisitors;
                    auctionVisitors.update()
                    Notiflix.Block.remove('#AuctionVisitorsCard')
                }).catch(function (err) {

                })
        }

        async function getVisitorsHistory(){
            let url = "{{route('user.auction.visitors.history',$auction_id)}}"
            axios.get(url)
                .then(function (res){
                    console.log(res.data)
                    deviceHistory.config.data.labels = Object.keys(res.data.visitorsDeviceData);
                    deviceHistory.config.data.datasets[0].data =  Object.values(res.data.visitorsDeviceData);
                    deviceHistory.update();
                    Notiflix.Block.remove('#DeviceCard');
                    getBrowserHistory.config.data.labels = Object.keys(res.data.visitorsBrowserData);
                    getBrowserHistory.config.data.datasets[0].data =  Object.values(res.data.visitorsBrowserData);
                    getBrowserHistory.update();
                    Notiflix.Block.remove('#BrowserCard')
                    getOperatinSystem.config.data.labels = Object.keys(res.data.visitorsOSData);
                    getOperatinSystem.config.data.datasets[0].data =  Object.values(res.data.visitorsOSData);
                    getOperatinSystem.update();
                    Notiflix.Block.remove('#OperatingSystemCard');
                })
        }
    </script>
@endpush
@push('style')
    <style>
        .bidderProfileImage {
            height: 40px !important;
            width: 40px !important;
            border-radius: 50px !important;
        }
        #GetDeviceHistory{
            width: 60% !important;
            height: 60%!important;
            display: block;
            margin:auto;
        }

        #GetBrowserHistory{
            width: 60% !important;
            height: 60%!important;
            display: block;
            margin:auto;
        }
        #GetOperatingSystemHistory{
            width: 60% !important;
            height: 60%!important;
            display: block;
            margin:auto;
        }
    </style>
@endpush
