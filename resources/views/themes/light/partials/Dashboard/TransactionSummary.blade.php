<div class="col-xl-6 col-lg-12" id="TransactinSummaryCard">
    <div class="card rounded-4 mb-4">
       <div class="card-header bg-white">
           <h4 class="card-header-title">
               @lang('Transaction Summary')
           </h4>
       </div>
        <div class="card-box">
            <canvas  id="myChart"></canvas>
        </div>
    </div>
</div>


@push('script')
    <script >
       $(document).ready(function (){
           Notiflix.Block.standard('#TransactinSummaryCard');
           const transactionSummary =    new Chart("myChart", {
               type: "line",
               data: {
                   labels: [],
                   datasets: [{
                       data: [],
                       label: "Purchase Plan",
                       borderColor: "#00cec9",
                       fill: false
                   },{
                       data: [],
                       label: "Deposit",
                       borderColor: "#feba27",
                       fill: false
                   },{
                       data: [],
                       label: "Payout",
                       borderColor: "#bdc3c7",
                       fill: false
                   }]
               },
               options: {
                   legend: {display: true}
               }
           });
           getChartData();
           async function getChartData(){
               let $url = "{{ route('user.get.chart.data') }}"
               await axios.get($url)
                   .then(function (res) {
                       transactionSummary.config.data.labels =  res.data.labels;
                       transactionSummary.config.data.datasets[0].data = res.data.purchasePlan;
                       transactionSummary.config.data.datasets[1].data = res.data.deposit;
                       transactionSummary.config.data.datasets[2].data = res.data.payout;
                       transactionSummary.update();
                       Notiflix.Block.remove('#TransactinSummaryCard');
                   })
                   .catch(function (error) {

                   });
           }
       })
    </script>
@endpush
