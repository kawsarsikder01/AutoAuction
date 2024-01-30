@extends($theme . 'layouts.app')
@section('title',trans($pageSeo->page_title ?? ''))
@section('content')
    <x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
    <div class="container-fluid mt-5 mb-5">
        <div class="main row">
            <div class="col-12">
                <!-- checkout section -->
                <div class="container px-0 px-lg-3">
                    <div class="checkout-section">
                        <form action="{{ route('user.confirm-plan') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{$plan_id}}"/>
                            <div class="row g-4 g-lg-5">
                                <div class="col-md-6 col-lg-7">

                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <div class="payment-box mb-4">
                                                <h5 class="payment-option-title mb-4">@lang('Select Payment')</h5>
                                                <div class="payment-option-wrapper">
                                                    <div class="payment-options">
                                                        <div class="row g-2 d-flex justify-content-center ">
                                                            @forelse($gateways as $method)
                                                            <div class="col-4 col-sm-3 col-md-3 col-xl-2 gateways">
                                                                    <input type="radio" class="btn-check selectPayment "
                                                                       name="gateway_id"
                                                                       id="{{ $method->name }}"
                                                                       value="{{ $method->id }}"
                                                                       autocomplete="off"/>
                                                                <label
                                                                       for="{{ $method->name }}">
                                                                    <img
                                                                        class="img-fluid cursor-pointer"
                                                                        src="{{ getFile($method->driver,$method->image ) }}"
                                                                        alt=""/>
                                                                </label>
                                                                {{-- <i class="fas fa-check-circle check"></i> --}}
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
                                                    <input class="form-control @error('amount') is-invalid @enderror"
                                                           type="hidden" value="{{$plan->price}}" id="amount"/>


                                            <div class="col-md-12 input-box mt-3">
                                                <label for="">@lang('Select Currency')</label>
                                                <select class="js-example-basic-single form-control"
                                                        name="supported_currency"
                                                        id="supported_currency">
                                                </select>
                                            </div>

                                            <div class="col-md-12 input-box mt-3 add-select-field">

                                            </div>

                                        </div>
                                        <div class="side-box">
                                            <h5>@lang('Payment Summery')</h5>
                                            <div class="showCharge">

                                            </div>
                                        </div>

                                        <button type="submit" class="btn-custom w-100 check mt-3">@lang('Make Payment')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include($theme . 'sections.footer')
@endsection


@push('script')
    <script>
        'use strict';


        $(document).ready(function () {
            $('.gateways').on('click',function(){
                $(this).append('<i class="fas fa-check-circle check"></i>')
                $('.gateways').not(this).removeClass('active').find('i').hide();
                $(this).addClass('active').find('i').show();
            })
            let amountField = $('#amount');
            let amountStatus = false;
            let selectedGateway = "";

            function clearMessage(fieldId) {
                // $(fieldId).removeClass('is-valid')
                // $(fieldId).removeClass('is-invalid')
                // $(fieldId).closest('div').find(".invalid-feedback").html('');
                // $(fieldId).closest('div').find(".is-valid").html('');
            }

            $(document).on('click', '.selectPayment', function () {
                let id = this.id;
                selectedGateway = $(this).val();
                supportCurrency(selectedGateway);
            });

            function supportCurrency(selectedGateway) {
                if (!selectedGateway) {
                    console.error('Selected Gateway is undefined or null.');
                    return;
                }

                $('#supported_currency').html('');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('supported.currency') }}",
                    data: {gateway: selectedGateway},
                    type: "GET",
                    success: function (response) {

                        if (response.data === "") {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        let markup = '<option value="">Selected Currency</option>';
                        $('#supported_currency').append(markup);


                        if (response.currencyType === 1) {
                            $(response.data).each(function (index, value) {
                                let markup = `<option value="${value}">${value}</option>`;
                                $('#supported_currency').append(markup);
                            });
                        } else {
                            let markup = `<option value="USD">USD</option>`;
                            $('#supported_currency').append(markup);
                        }

                        let markup2 = '<option value="">Selected Crypto Currency</option>';
                        $('#supported_crypto_currency').append(markup2);

                        if (response.currencyType === 0){
                            let markup2 = `<label >Pay To Crypto Currency</label>
                                        <select class="js-example-basic-single form-control"
                                                name="supported_crypto_currency"
                                                id="supported_crypto_currency">
                                              <option value="">Selected Crypto Currency</option>
                                        </select>`;
                            $('.add-select-field').append(markup2);

                            $(response.data).each(function (index, value) {
                                let markupOption = `<option value="${value}">${value}</option>`;
                                $('#supported_crypto_currency').append(markupOption);
                            });
                        }
                    },
                    error: function (error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }


            $(document).on('change, input', "#amount, #supported_currency, .selectPayment, #supported_crypto_currency", function (e) {

                let amount = amountField.val();
                let selectedCurrency = $('#supported_currency').val();
                let selectedCryptoCurrency = $('#supported_crypto_currency').val();
                let currency_type = 1;

                if (!isNaN(amount) && amount > 0) {
                    let fraction = amount.split('.')[1];
                    let limit = currency_type == 0 ? 8 : 2;

                    if (fraction && fraction.length > limit) {
                        amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
                        amountField.val(amount);
                    }

                    checkAmount(amount, selectedCurrency, selectedGateway, selectedCryptoCurrency)

                    if (selectedCurrency != null) {

                    }
                } else {
                    clearMessage(amountField)
                    $('.showCharge').html('')
                }
            });

            function checkAmount(amount, selectedCurrency, selectGateway, selectedCryptoCurrency = null) {
                $.ajax({
                    method: "GET",
                    url: "{{ route('user.plan.checkAmount') }}",
                    dataType: "json",
                    data: {
                        'amount': amount,
                        'selected_currency': selectedCurrency,
                        'select_gateway': selectGateway,
                        'selectedCryptoCurrency': selectedCryptoCurrency,
                    }
                }).done(function (response) {

                    console.log(response)

                    let amountField = $('#amount');
                    if (response.status) {
                        clearMessage(amountField);
                        $(amountField).addClass('is-valid');
                        $(amountField).closest('div').find(".valid-feedback").html(response.message);
                        amountStatus = true;
                        let base_currency = "{{basicControl()->base_currency}}"
                        showCharge(response, base_currency);
                    } else {
                        amountStatus = false;
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
							<span>{{ __('Payable Amount') }}</span>
							<span class="text-info"> ${response.payable_amount} ${response.currency}</span>
						</li>

						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Exchange Rate') }}</span>
							<span class="text-info"> 1 ${currency} <i class="fa-light fa-arrow-right-arrow-left fa-sm"></i>  ${response.conversion_rate} ${response.currency}</span>
						</li>


						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Payable Amount') }} <sub>(In Base Currency)</sub></span>
							<span class="text-info"> ${response.amount_in_base_currency} ${currency}</span>
						</li>

					</ul>`;
                $('.showCharge').html(txnDetails)
            }

        });


    </script>
@endpush




@push('style')
    <style>
          .gateways{
            margin: 10px;
            box-shadow: 2px 3px 4px rgba(0, 0, 0, 0.6);
            cursor: pointer !important;
            position: relative;
            padding: 0;
          }
          .gateways label img{
            border-radius: 3px;
            aspect-ratio: 5/3;
            -o-object-fit: cover;
            object-fit: cover;
            cursor: pointer !important;
          }
          .gateways label{
            cursor: pointer !important;
          }
          .payment-options .active{
              box-shadow:1px 1px 3px rgba(0, 0, 0, 0.6);
          }
          .gateways i{
            position:absolute;
            top: -5px;
            right: 0;
            font-size: 18px;
            color: rgb(16, 194, 16);
          }
          .showCharge li{
            margin-top: 15px;
            border-radius: 0px;
          }
          .list-group-item:first-child{
            border-top-left-radius: 0;
            border-top-right-radius: 0;
          }
          .list-group-item:last-child {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
          }
          h5{
            font-size: 25px;
          }
          .payment-box{
            border: 1px solid ;
            padding: 20px;
          }
          .checkout-section .side-bar .side-box {
                background: var(--bgLight);
                box-shadow: 2px 3px 4px rgba(0, 0, 0, 0.6);
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
            @media (max-width: 575px) {
                .payment-options{
                    height: 300px;
                    overflow: hidden;
                    overflow-y: auto;
                }
            }

    </style>
@endpush
