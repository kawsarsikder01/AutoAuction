<div class="card rounded-4">
    <div class="card-header bg-white">
        <h4 class="card-header-title">
            @lang('Top Bid History')
        </h4>
    </div>
    <div class="card-body">
        <table class="table table-striped ">
            <thead >
            <tr>
                <th scope="col">@lang('Title')</th>
                <th scope="col">@lang('Total Bid')</th>
                <th scope="col">@lang('Max Bid')</th>
            </tr>
            </thead>
            <tbody id="topBidHistoryTable">
            @foreach($vehicles as $vehicle)
                <tr>
                    <td data-label="@lang('Title')"><a href="{{route('auction.details',[$vehicle->details->title,$vehicle->id])}}" class="text-black" id="topBidHistoryVehiclesLink">{{$vehicle->details->title}}</a></td>
                    <td data-label="@lang('Total Bid')">{{$vehicle->bidding_history_count}}</td>
                    <td data-label="@lang('Max Bid')">{{currencyPosition($vehicle->biddingHistory->max('bid_amount'))}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('style')
    <style>
        #topBidHistoryVehiclesLink:hover{
            text-decoration: underline;
        }
    </style>
@endpush
