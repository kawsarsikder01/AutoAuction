@extends($theme.'layouts.user')
@section('title',trans('Payout'))
@section('content')
    @push('style')
        <style>
            .checkout-section {
                background: var(--white);
                box-shadow: var(--shadow);
                border-radius: 5px;
                padding: 20px;
            }

            .checkout-section form .input-box label {
                font-weight: 400;
                font-size: 15px;
                margin-bottom: 10px;
                text-transform: capitalize;
            }

            .checkout-section form .input-box .form-select,
            .checkout-section form .input-box .form-control {
                height: 45px;
                border-radius: 5px !important;
                background-color: var(--bgLight);
                border: 1px solid var(--bgLight);
                padding: 10px;
                padding-left: 15px;
                font-weight: normal;
                caret-color: var(--primary);
                color: var(--fontColor);
            }

            .checkout-section form .input-box .form-select:focus,
            .checkout-section form .input-box .form-control:focus {
                color: var(--fontColor);
                box-shadow: 0 0 0 0rem var(--white);
                border: 1px solid var(--primary);
            }

            .checkout-section form .input-box .form-select::-moz-placeholder, .checkout-section form .input-box .form-control::-moz-placeholder {
                color: var(--fontColor);
            }

            .checkout-section form .input-box .form-select::placeholder,
            .checkout-section form .input-box .form-control::placeholder {
                color: var(--fontColor);
            }

            /*.checkout-section form .input-box .form-select {*/
            /*    background-image: url(../img/icon/downward-arrow.png);*/
            /*}*/
            .checkout-section form .input-box .form-select option {
                background: var(--white);
                color: var(--fontColor);
            }

            .checkout-section form .input-box textarea.form-control {
                height: 150px;
                border-radius: 5px;
            }

            .checkout-section form .select2 {
                width: calc(100% - 0px) !important;
                width: 100%;
                margin-left: auto;
            }

            .checkout-section form .select2-container--default .select2-selection--single {
                height: 45px;
                background: var(--bgLight);
                border: 1px solid var(--bgLight);
            }

            .checkout-section form .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 45px;
                padding-left: 10px;
                padding-right: 10px;
                color: var(--fontColor);
            }

            .checkout-section .payment-box .btn-check + .btn-primary {
                background: var(--white);
                border: 1px solid transparent !important;
                border-radius: 5px;
                padding: 5px;
                color: #212529;
                position: relative;
                transition: 0.4s;
            }

            .checkout-section .payment-box .btn-check + .btn-primary .check {
                position: absolute;
                left: 10px;
                top: 10px;
                opacity: 0;
                width: 18px;
                color: #00d170;
            }

            .checkout-section .payment-box .btn-check + .btn-primary::after {
                position: absolute;
                content: "";
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
            }

            .checkout-section .payment-box label img {
                border-radius: 3px;
                aspect-ratio: 5/3;
                -o-object-fit: cover;
                object-fit: cover;
            }

            .checkout-section .payment-box .btn-check:checked + .btn-primary {
                background: var(--white) !important;
                border: 1px solid var(--primary) !important;
            }

            .checkout-section .payment-box .btn-check:checked + .btn-primary .check {
                opacity: 1;
            }

            .checkout-section .payment-box .btn-check:checked + .btn-primary::after {
                background: none;
            }

            .checkout-section .payment-box .btn-check:focus + .btn-primary,
            .checkout-section .payment-box .btn-primary:focus {
                color: var(--white);
                background-color: var(--white);
                border-color: var(--primary);
                box-shadow: 0 0 0 0rem rgba(49, 132, 253, 0.5);
            }

            .checkout-section .payment-box .payment-option-title {
                background: var(--white);
                display: inline-block;
                margin: 0 15px 15px 15px;
                padding: 0 10px;
            }

            .checkout-section .payment-box .payment-option-wrapper {
                margin-top: -30px;
                border: 1px solid var(--borderColor);
                padding: 15px;
                padding-top: 30px;
                border-radius: 5px;
            }

            .checkout-section .payment-box .payment-options {
                min-height: 165px;
                overflow-y: auto;
                overflow-x: hidden;
            }

            .checkout-section .payment-box .payment-options::-webkit-scrollbar {
                width: 2px;
            }

            .checkout-section .payment-box .payment-options::-webkit-scrollbar-track {
                background: transparent;
                border-radius: 100px;
            }

            .checkout-section .payment-box .payment-options::-webkit-scrollbar-thumb {
                background: var(--borderColor);
                border-radius: 6px;
            }

            .checkout-section .payment-box .payment-options::-webkit-scrollbar-thumb:hover {
                background: var(--primary);
            }

            .checkout-section .side-bar .side-box {
                background: var(--bgLight);
                border-radius: 5px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .checkout-section .side-bar .side-box h4 {
                text-transform: capitalize;
                margin-bottom: 15px;
                position: relative;
            }

            .checkout-section .side-bar .side-box ul {
                margin-bottom: 0;
                padding-left: 0;
                list-style: none;
            }

            .checkout-section .side-bar .side-box ul li {
                margin-bottom: 10px;
                /*border-bottom: 1px solid var(--bgLight);*/
                padding-bottom: 10px;
            }

            .list-group-item:first-child {
                border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
            }


            .checkout-section .side-bar .side-box ul li span {
                float: right;
            }

            .checkout-section .side-bar .side-box ul li:last-child {
                margin-bottom: 0;
                border-bottom: none;
            }

            .checkout-section .side-bar .side-box .form-control {
                height: 45px;
                background-color: var(--white);
                border: 1px solid var(--white) !important;
                padding: 10px;
                padding-left: 15px;
                font-weight: normal;
                caret-color: var(--primary);
                color: var(--fontColor);
            }


            .checkout-section form .select2 {
                width: calc(100% - 0px) !important;
                width: 100%;
                margin-left: auto;
            }

            .checkout-section .side-bar .side-box .select2-container--default .select2-selection--single {
                height: 45px;
                background-color: var(--white);
                border: 1px solid var(--white);
            }

            .checkout-section .side-bar .side-box .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 45px;
                padding-left: 10px;
                padding-right: 10px;
            }


            .checkout-section .side-bar .side-box .input-group .form-control:focus {
                color: var(--fontColor);
                box-shadow: 0 0 0 0rem var(--white);
                border: 1px solid var(--primary);
            }

            .checkout-section .side-bar .side-box .input-group .form-control::-moz-placeholder {
                color: var(--fontColor);
            }

            .checkout-section .side-bar .side-box .input-group .form-control::placeholder {
                color: var(--fontColor);
            }

            .rtl .checkout-section .side-bar .side-box ul li span {
                float: left;
            }

            .rtl .checkout-section .payment-box .btn-check + .btn-primary .check {
                position: absolute;
                left: auto;
                right: 15px;
                top: 15px;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <!-- checkout section -->
                <div class="container px-0 px-lg-3">
                    <div class="checkout-section">
                        <form action="{{ route('user.payout.request') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4 g-lg-5">
                                <div class="col-md-6 col-lg-7">
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <div class="payment-box mb-4">
                                                <h5 class="payment-option-title">@lang('Select Payment')</h5>
                                                <div class="payment-option-wrapper">
                                                    <div class="payment-options">
                                                        <div class="row g-2">
                                                            @forelse($payoutMethod as $method)
                                                                <div
                                                                    class="col-4 col-sm-3 col-md-3 col-xl-2">
                                                                    <input type="radio"
                                                                           class="btn-check selectPayoutMethod"
                                                                           name="payout_method_id"
                                                                           id="{{ $method->name }}"
                                                                           value="{{ $method->id }}"
                                                                           autocomplete="off"/>
                                                                    <label class="btn btn-primary"
                                                                           for="{{ $method->name }}">
                                                                        <img
                                                                            class="img-fluid"
                                                                            src="{{ getFile($method->driver,$method->logo ) }}"
                                                                            alt=""/>
                                                                        <i class="fas fa-check-circle check"></i>
                                                                    </label>
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6 col-lg-5">
                                    <div class="side-bar">
                                        <div class="side-box mt-2">
                                            <div class="col-md-12 input-box">
                                                <label for="">Enter Amount</label>
                                                <div class="input-group">
                                                    <input class="form-control @error('amount') is-invalid @enderror"
                                                           name="amount"
                                                           type="text" id="amount"
                                                           placeholder="Enter Amount" autocomplete="off"/>
                                                    <button id="copyBtn" class="btn text-white">
                                                        {{ $basic->base_currency }}
                                                    </button>
                                                    <div class="invalid-feedback">
                                                        @error('amount') @lang($message) @enderror
                                                    </div>
                                                    <div class="valid-feedback"></div>
                                                </div>


                                            </div>

                                            <div class="col-md-12 input-box mt-3">
                                                <label for="">Select Currency</label>
                                                <select class="js-example-basic-single form-control"
                                                        name="supported_currency"
                                                        id="supported_currency">
                                                </select>
                                            </div>


                                        </div>
                                        <div class="side-box">
                                            <h5>Payout Summery</h5>
                                            <div class="showCharge">

                                            </div>
                                        </div>
                                        <button type="submit" class="btn-custom w-100 check">Make Payment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';


        $(document).ready(function () {
            let amountField = $('#amount');
            let amountStatus = false;
            let selectedPayoutMethod = "";

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }

            $(document).on('click', '.selectPayoutMethod', function () {
                let id = this.id;

                selectedPayoutMethod = $(this).val();
                supportCurrency(selectedPayoutMethod);
            });

            function supportCurrency(selectedPayoutMethod) {
                if (!selectedPayoutMethod) {
                    console.error('Selected Gateway is undefined or null.');
                    return;
                }

                $('#supported_currency').empty();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('user.payout.supported.currency') }}",
                    data: {gateway: selectedPayoutMethod},
                    type: "GET",
                    success: function (data) {

                        if (data === "") {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        let markup = '<option value="">Selected Currency</option>';
                        $('#supported_currency').append(markup);

                        $(data).each(function (index, value) {

                            let markup = `<option value="${value}">${value}</option>`;
                            $('#supported_currency').append(markup);
                        });
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }


            $(document).on('change, input', "#amount, #supported_currency, .selectPayoutMethod", function (e) {

                let amount = amountField.val();
                let selectedCurrency = $('#supported_currency').val();
                let currency_type = 1;

                if (!isNaN(amount) && amount > 0) {

                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;


                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        amountField.val(amount);
                    }

                    checkAmount(amount, selectedCurrency, selectedPayoutMethod)


                } else {
                    clearMessage(amountField)
                    $('.showCharge').html('')
                }
            });


            function checkAmount(amount, selectedCurrency, selectedPayoutMethod) {

                $.ajax({
                    method: "GET",
                    url: "{{ route('user.payout.checkAmount') }}",
                    dataType: "json",
                    data: {
                        'amount': amount,
                        'selected_currency': selectedCurrency,
                        'selected_payout_method': selectedPayoutMethod,
                    }
                }).done(function (response) {
                    console.log(response)
                    let amountField = $('#amount');
                    if (response.status) {
                        clearMessage(amountField);
                        $(amountField).addClass('is-valid');
                        $(amountField).closest('div').find(".valid-feedback").html(response.message);
                        amountStatus = true;
                        let base_currency ="{{basicControl()->base_currency}}"
                        showCharge(response, base_currency);
                    } else {
                        amountStatus = false;
                        // submitButton();
                        $('.showCharge').html('');
                        clearMessage(amountField);
                        $(amountField).addClass('is-invalid');
                        $(amountField).closest('div').find(".invalid-feedback").html(response.message);
                    }


                });
            }


            function showCharge(response, currency) {
                let txnDetails = `<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Amount In') }} ${response.currency} </span>
							<span class="text-success"> ${response.amount} ${response.currency}</span>
						</li>

						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Charge') }}</span>
							<span class="text-danger">  ${response.charge} ${response.currency}</span>
						</li>


						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Payout Amount') }}</span>
							<span class="text-info"> ${response.net_payout_amount} ${response.currency}</span>
						</li>

						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Exchange Rate') }}</span>
							<span class="text-info"> 1 ${currency} <i class="fa-light fa-arrow-right-arrow-left fa-sm"></i>  ${response.conversion_rate} ${response.currency}</span>
						</li>


						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Payout Amount') }} <sub>(In Base Currency)</sub></span>
							<span class="text-info"> ${response.amount_in_base_currency} ${currency}</span>
						</li>
					</ul>`;
                $('.showCharge').html(txnDetails)
            }



        });


    </script>
@endpush







