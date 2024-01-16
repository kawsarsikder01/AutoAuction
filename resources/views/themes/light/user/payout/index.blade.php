@extends($theme.'layouts.user')
@section('page_title',__('Payout List'))

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="table-parent table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>@lang('SL')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Transaction ID')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Created time')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($payouts as $key => $value)

                            <tr>
                                <td data-label="@lang('SL')">{{ $loop->index + 1 }}</td>
                                <td data-label="@lang('Amount')">{{ (getAmount($value->amount)).' '.$value->payout_currency_code }}</td>
                                <td data-label="@lang('Transaction ID')">{{ __($value->trx_id) }}</td>
                                <td data-label="@lang('Status')">
                                    @if($value->status == 0)
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif($value->status == 1)
                                        <span class="badge bg-info">@lang('Generated')</span>
                                    @elseif($value->status == 2)
                                        <span class="badge bg-success">@lang('Payment Done')</span>
                                    @elseif($value->status == 3)
                                        <span class="badge bg-danger">@lang('Canceled')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Created time')"> {{ dateTime($value->created_at)}} </td>
                                <td data-label="@lang('Action')">
                                    @if($value->status == 0)
                                        <a href="{{ route('user.payout.confirm',$value->trx_id) }}" target="_blank"
                                           class="btn btn-sm btn-primary">@lang('Confirm')</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="100%" class="text-center">@lang('No data found')</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <!-- pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end mt-4">
                            {{ $payouts->appends($_GET)->links($theme.'partials.pagination') }}
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

@endsection

