<div class="row">
    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
        <div class="card custom-chart" id="DeviceCard">
            <div class="card-header bg-white">
                <h4 class="card-header-title d-block m-auto p-1">
                    @lang('Device History')
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
                    @lang('Browser History')
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
                    @lang('Operating System History')
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

@push('script')
    <script>
        $(document).ready(function (){
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
            getLoginHistory();
            async function getLoginHistory(){
                let $url = "{{ route('user.get.userLogin.history') }}"
                await axios.get($url)
                    .then(function (res) {
                        deviceHistory.config.data.labels = Object.keys(res.data.userLoginsDeviceData);
                        deviceHistory.config.data.datasets[0].data =  Object.values(res.data.userLoginsDeviceData);
                        deviceHistory.update();
                        Notiflix.Block.remove('#DeviceCard');
                        getBrowserHistory.config.data.labels = Object.keys(res.data.userLoginsBrowserData);
                        getBrowserHistory.config.data.datasets[0].data =  Object.values(res.data.userLoginsDeviceData);
                        getBrowserHistory.update();
                        Notiflix.Block.remove('#BrowserCard')
                        getOperatinSystem.config.data.labels = Object.keys(res.data.userLoginsOSData);
                        getOperatinSystem.config.data.datasets[0].data =  Object.values(res.data.userLoginsOSData);
                        getOperatinSystem.update();
                        Notiflix.Block.remove('#OperatingSystemCard');
                    })
                    .catch(function (error) {

                    });
            }
        })
    </script>
@endpush
