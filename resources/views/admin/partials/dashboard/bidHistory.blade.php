<div class="card mb-3 mb-lg-5" id="bidHistoryCard">
    <!-- Header -->
    <div class="card-header card-header-content-sm-between">
        <h4 class="card-header-title mb-2 mb-sm-0">Bid History </h4>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <div class="row col-lg-divider">
            <div class="col-lg-9 mb-5 mb-lg-0">
                <!-- Bar Chart -->
                <div class="chartjs-custom mb-4">
                    <canvas id="bidHistory" style="height:20rem "></canvas>
                </div>
                <!-- End Bar Chart -->
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
                <!-- End Row -->
            </div>

            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-6 col-lg-12">
                        <!-- Stats -->
                        <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                            <h6 class="card-subtitle">Total Bid</h6>
                            <span class="d-block display-6 text-dark mb-1 me-3"  id="totalBid"></span>

                        </div>
                        <!-- End Stats -->

                        <hr class="d-none d-lg-block my-0">
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-6 col-lg-12">
                        <!-- Stats -->
                        <div class="d-flex justify-content-center flex-column aside-sales-chart-height">
                            <h6 class="card-subtitle" >Today Bid</h6>
                            <span class="d-block display-6 text-dark mb-1 me-3" id="todayTotalBid"></span>
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


@push('script')
    <script>
        Notiflix.Block.standard('#bidHistoryCard');
        HSCore.components.HSChartJS.init(document.querySelector('#bidHistory'), {
                type: "bar",
                data: {
                    labels: ["1AM","2AM","3AM","4AM","5AM","6AM","7AM","8AM","9AM","10AM","11AM"],
                    datasets: [{
                        data: [],
                        backgroundColor: "#377dff",
                        hoverBackgroundColor: "#377dff",
                        borderColor: "#377dff",
                        maxBarThickness: "10"
                    },
                        {
                            data: [],
                            backgroundColor: "#e7eaf3",
                            borderColor: "#e7eaf3",
                            maxBarThickness: "10"
                        }]
                },
                options: {
                    scales: {
                        y: {
                            grid: {
                                color: "#e7eaf3",
                                drawBorder: false,
                                zeroLineColor: "#e7eaf3"
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 100,
                                color: "#97a4af",
                                font: {
                                    size: 12,
                                    family: "Open Sans, sans-serif"
                                },
                                padding: 10
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
                                padding: 5
                            },
                            categoryPercentage: 0.5,
                            maxBarThickness: "10"
                        }
                    },
                    cornerRadius: 2,
                    plugins: {
                        tooltip: {
                            hasIndicator: true,
                            mode: "index",
                            intersect: false
                        }
                    },
                    hover: {
                        mode: "nearest",
                        intersect: true
                    }
                }
            });
        // }
        const bidHistory = HSCore.components.HSChartJS.getItem('bidHistory');
        getBidHistory();

        async function getBidHistory() {
            let $url = "{{ route('admin.get.bidHistory') }}"
            await axios.get($url)
                .then(function (res) {
                    console.log(res.data)
                    bidHistory.data.labels = res.data.labels;
                    bidHistory.data.datasets[0].data = res.data.hourlyBid;
                    bidHistory.data.datasets[1].data = res.data.yesterdayHourlyBid;
                    bidHistory.update();
                    $('#totalBid').text(res.data.totalBid);
                    $('#todayTotalBid').text(res.data.todayTotalBid)
                    Notiflix.Block.remove('#bidHistoryCard');
                })
                .catch(function (error) {

                });
        }
    </script>
@endpush
