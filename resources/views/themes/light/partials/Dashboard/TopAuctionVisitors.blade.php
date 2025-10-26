<div class="card rounded-4 mb-4">
    <div class="card-header bg-white">
        <h4 class="card-header-title">
            @lang('Top Auction Visitors')
        </h4>
    </div>
    <div class="card-body">
        <canvas  id="Visitors"></canvas>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function (){
            const visitors =  new Chart("Visitors", {
                type: "bar",
                data: {
                    labels: [],
                    datasets: [{
                        axis: 'y',
                        label: 'Visitors',
                        data: [],
                        fill: false,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                }
            });
            Notiflix.Block.standard('#visitorCard');
            getTopAuctionVisitors();
            async function getTopAuctionVisitors(){
                let $url = "{{ route('user.top.auction.visitors') }}"
                await axios.get($url)
                    .then(function (res) {
                        visitors.config.data.labels = res.data.labels;
                        visitors.config.data.datasets[0].data = res.data.topVisitedAuction;
                        visitors.update();
                        Notiflix.Block.remove('#visitorCard');
                    })
                    .catch(function (error) {

                    });
            }
        })
    </script>
@endpush
