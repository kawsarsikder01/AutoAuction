@extends($theme.'layouts.user')
@section('title',trans('Add Fund List'))
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
                            <th scope="col">@lang('Transaction ID')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Created time')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($funds as $key => $value)
                            <tr>
                                <td data-label="@lang('Method')">{{ __(optional($value->gateway)->name) ?? __('N/A') }}</td>
                                <td data-label="@lang('Transaction ID')">{{ __($value->trx_id) }}</td>
                                <td data-label="@lang('Requested Amount')">{{ currencyPosition(getAmount($value->payable_amount_in_base_currency)) }}</td>
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
                    @if (count($funds) == 0)
                        <div class="text-center p-4" >
                            <img  class="dataTables-image mb-3"
                                  id="emptyImage"
                                  src="{{ asset($themeTrue.'img/img/no-data.png') }}"
                                  alt="Image Description">
                            <p class="mb-0">@lang("No Data Found")</p>
                        </div>
                    @endif
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

