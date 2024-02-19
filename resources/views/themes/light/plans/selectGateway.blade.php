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
                        <div class="card p-4">
                            <form action="{{ route('user.confirm-plan') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{$plan_id}}"/>
                                <div class="row g-4 g-lg-5">
                                    <div class="col-md-6 col-lg-7">
                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <div class="payment-box">
                                                    <h7 class="payment-option-title">@lang('Select Payment')</h7>
                                                    <div class="payment-option-wrapper">
                                                        <div class="payment-section">
                                                            <ul class="payment-container-list">
                                                                <li class="item">
                                                                    <input class="form-check-input"
                                                                           value="website_wallet" type="radio"
                                                                           name="gateway_id"
                                                                           id="wallet" >
                                                                    <label class="form-check-label"
                                                                           for="wallet">
                                                                        <div class="image-area">
                                                                            <img
                                                                                src="{{asset($themeTrue.'img/img/wallet1.png')}}"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="content-area">
                                                                            <h5>@lang('Wallet')</h5>
                                                                            <span>@lang('Pay from your wallet')</span>
                                                                        </div>
                                                                    </label>

                                                                </li>
                                                                @forelse($gateways as $method)
                                                                    <li class="item">
                                                                        <input class="form-check-input selectPayment"
                                                                               value="{{ $method->id }}" type="radio"
                                                                               name="gateway_id"
                                                                               id="{{ $method->name }}" >
                                                                        <label class="form-check-label"
                                                                               for="{{ $method->name }}">
                                                                            <div class="image-area">
                                                                                <img
                                                                                    src="{{ getFile($method->driver,$method->image ) }}"
                                                                                    alt="">
                                                                            </div>
                                                                            <div class="content-area">
                                                                                <h5>{{$method->name}}</h5>
                                                                                <span>{{$method->description}}</span>
                                                                            </div>
                                                                        </label>

                                                                    </li>
                                                                @empty
                                                                @endforelse
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="side-bar">
                                            <div class="side-box mt-5" id="GatewayForm">
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
                                            <div class="side-box payment_summary">
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
    </div>
    @include($theme . 'sections.footer')
@endsection


@push('script')
    <script>
        'use strict';


        $(document).ready(function () {
            $(document).on('click','#wallet',function (){
                $('#GatewayForm').hide();
                $('.payment_summary').addClass('mt-5');
                let price = @json(currencyPosition($plan->price));
                let showCharge = $('.showCharge');
                showCharge.empty();
                let htmlElement = `<ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ __('Payable Amount') }}  </span>
                                            <span class="text-success"> ${price}</span>
                                        </li>
                                    </ul>`
                showCharge.append(htmlElement);
            })
            let amountField = $('#amount');
            let amountStatus = false;
            let selectedGateway = "";

            function clearMessage(fieldId) {
                $(fieldId).removeClass('is-valid')
                $(fieldId).removeClass('is-invalid')
                $(fieldId).closest('div').find(".invalid-feedback").html('');
                $(fieldId).closest('div').find(".is-valid").html('');
            }

            $(document).on('click', '.selectPayment', function () {
                $('#GatewayForm').show();
                $('.payment_summary').removeClass('mt-5');
                let id = this.id;
                selectedGateway = $(this).val();
                supportCurrency(selectedGateway);
            });

            function supportCurrency(selectedGateway) {
                console.log(selectedGateway);
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




