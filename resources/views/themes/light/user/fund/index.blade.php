@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')

    <!-- main -->
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="table-parent table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('Method')</th>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($funds as $key => $value)
                            <tr>
                                <td data-label="@lang('Method')">{{ __(optional($value->gateway)->name) ?? __('N/A') }}</td>
                                <td data-label="@lang('Transaction ID')">{{ __($value->trx_id) }}</td>
                                <td data-label="@lang('Requested Amount')">{{ currencyPosition(getAmount($value->amount)) }}</td>
                                <td data-label="@lang('Status')">
                                    @if($value->status == 0)
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif($value->status == 1)
                                        <span class="badge bg-success">@lang('Success')</span>
                                    @elseif($value->status == 2)
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif($value->status == 3)
                                        <span class="badge bg-danger">@lang('Rejected')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mt-4">
                            {{ $funds->appends($_GET)->links($theme.'partials.pagination') }}
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

@endsection

