<div class="col-xl-6 col-lg-12">
    <div class="card rounded-4 mb-4" id="bidHistoryCard">
        <div class="card-header bg-white">
            <h4 class="card-header-title">
                @lang('Bid History')
            </h4>
        </div>
        <div class="card-box" >
            <canvas  id="BidHistory"></canvas>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function (){
            Notiflix.Block.standard('#bidHistoryCard');
            const barColors = ["#0a3d62","#e67e22","#1abc9c","#079992","#18dcff","#0984e3","#e55039","#079992","#b71540","#f1c40f","#ff3838","#2ecc71","#7F27FF","#2c3e50","#f6e58d"];
            const bidHistory =   new Chart("BidHistory", {
                type: "bar",
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        label:'Bid History',
                        backgroundColor: barColors,
                    }]
                },
                options: {
                    legend: {display: true},
                }
            });
            getBidHistory();
            async function getBidHistory(){
                let $url = "{{ route('user.get.bidHistory') }}"
                await axios.get($url)
                    .then(function (res) {
                        bidHistory.config.data.labels = res.data.labels;
                        bidHistory.config.data.datasets[0].data = res.data.bidHistory;
                        bidHistory.update();
                        Notiflix.Block.remove('#bidHistoryCard');
                    })
                    .catch(function (error) {

                    });
            }
        })
    </script>
@endpush
