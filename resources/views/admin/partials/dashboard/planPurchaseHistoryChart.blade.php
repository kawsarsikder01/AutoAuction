<div class="col-lg-6">
    <!-- Body -->
    <div class="card-body" id="planPurchaseHistoryCard">
        <h4>Plan Purchase History  </h4>

        <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
            <div class="col-sm mb-3 mb-sm-0">
                <span class="display-6 text-dark me-2" id="totalPurchaseAmount"> </span>
            </div>
            <!-- End Col -->

            <div class="col-sm-auto">
                  <span class="">
                      Today Amount
                  </span>
                <span class="d-block"><span>&mdash;</span><span id="toDayPurchaseAmount"></span></span>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->

        <!-- Bar Chart -->
        <div class="chartjs-custom mb-4">
            <canvas id="planPurchaseHistory" style="height: 18rem;">
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


@push('script')
    <script>
        Notiflix.Block.standard('#planPurchaseHistoryCard');
        HSCore.components.HSChartJS.init(document.querySelector('#planPurchaseHistory'), {
            type: "line",
            data: {
                labels:[],
                datasets: [{
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "#377dff",
                    borderWidth: 2,
                    pointRadius: 0,
                    hoverBorderColor: "#377dff",
                    pointBackgroundColor: "#377dff",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 0,
                    tension: 0.4
                },
                {
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "#e7eaf3",
                    borderWidth: 2,
                    pointRadius: 0,
                    hoverBorderColor: "#e7eaf3",
                    pointBackgroundColor: "#e7eaf3",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 0,
                    tension: 0.4
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
                            padding: 10,
                            postfix: "k"
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
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        postfix: @json(basicControl()->currency_symbol),
                        hasIndicator: true,
                        mode: "index",
                        intersect: false,
                        lineMode: true,
                        lineWithLineColor: "rgba(19, 33, 68, 0.075)"
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            }
        });
        // }
        const planPurchaseHistory = HSCore.components.HSChartJS.getItem('planPurchaseHistory');
        getPlanPurchaseHistory();

        async function getPlanPurchaseHistory() {
            let $url = "{{ route('admin.planPurchaseHistory') }}"
            await axios.get($url)
                .then(function (res) {
                    planPurchaseHistory.data.labels = res.data.labels;
                    planPurchaseHistory.data.datasets[0].data = res.data.hourlyPurchaseHistory;
                    planPurchaseHistory.data.datasets[1].data = res.data.hourlyPurchaseHistoryYesterday;
                    planPurchaseHistory.update();
                   $('#toDayPurchaseAmount').text(' '+res.data.toDayPurchaseAmount);
                   $('#totalPurchaseAmount').text(res.data.totalPurchaseAmount)
                    Notiflix.Block.remove('#planPurchaseHistoryCard');
                })
                .catch(function (error) {

                });
        }
    </script>
@endpush
