@extends($theme.'layouts.user')
@section('title')
	{{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@section('content')
    @push('style')
        <link href="{{ asset('assets/admin/css/card-js.min.css') }}" rel="stylesheet" type="text/css"/>
        <style>
            .card-js .icon {
                top: 5px;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="main row d-flex justify-content-center">
            <div class="col-8">
                <div class="dashboard-heading">
                    <h4 class="mb-0">@yield('title')</h4>
                </div>
                <div class="card-box ">
                    <div class="card-body d-flex flex-wrap justify-content-center">
                        <div class="text-center">
                            <img
                                src="{{ getFile(optional($deposit->gateway)->driver, optional($deposit->gateway)->image) }}"
                                class="w-50">
                        </div>
                        <div>

                            <h4 class="card-title text-center mb-4 mt-5"> @lang('Your Card Information')</h4>

                            <form class="form-horizontal" id="example-form"
                                  action="{{ route('ipn', [optional($deposit->gateway)->code ?? '', $deposit->transaction]) }}"
                                  method="post">
                                <div class="card-js form-group --payment-card">
                                    <input class="card-number form-control"
                                           name="card_number"
                                           placeholder="@lang('Enter your card number')"
                                           autocomplete="off"
                                           required>
                                    <input class="name form-control"
                                           id="the-card-name-id"
                                           name="card_name"
                                           placeholder="@lang('Enter the name on your card')"
                                           autocomplete="off"
                                           required>
                                    <input class="expiry form-control"
                                           autocomplete="off"
                                           required>
                                    <input class="expiry-month" name="expiry_month">
                                    <input class="expiry-year" name="expiry_year">
                                    <input class="cvc form-control"
                                           name="card_cvc"
                                           autocomplete="off"
                                           required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">@lang('Submit')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('script')
        <script src="{{ asset('assets/admin/js/card-js.min.js') }}"></script>
    @endpush

@endsection
