@extends($theme.'layouts.user')
@section('page_title')
	{{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-8">
                <div class="dashboard-heading">
                    <h4 class="mb-0">@yield('title')</h4>
                </div>
                <div class="card-box ">
                    <div class="card-body d-flex flex-wrap">
                        <div>
                            <img
                                src="{{ getFile(optional($deposit->gateway)->driver, optional($deposit->gateway)->image) }}"
                                class="w-50">
                        </div>
                        <div>
                            <h5 class="my-3">@lang('Please Pay') {{getAmount($deposit->payable_amount)}} {{$deposit->payment_method_currency}}</h5>
                            <button type="button" class="btn btn-primary"
                                    id="btn-confirm">@lang('Pay Now')</button>
                            <form
                                action="{{ route('ipn', [optional($deposit->gateway)->code, $deposit->utr]) }}"
                                method="POST">
                                @csrf
                                <script src="//js.paystack.co/v1/inline.js"
                                        data-key="{{ $data->key }}"
                                        data-email="{{ $data->email }}"
                                        data-amount="{{$data->amount}}"
                                        data-currency="{{$data->currency}}"
                                        data-ref="{{ $data->ref }}"
                                        data-custom-button="btn-confirm">
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

