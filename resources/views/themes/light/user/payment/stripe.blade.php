@extends($theme.'layouts.user')
@section('title')
    {{ __('Pay with ').__(optional($deposit->gateway)->name) }}
@endsection
@push('style')
@endpush
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
                                <form action="{{ $data->url }}" method="{{ $data->method }}">
                                    @csrf
                                    <input type="hidden" name="type" value="{{$type}}">
                                    <script src="{{ $data->src }}" class="stripe-button "
                                            @foreach($data->val as $key=> $value)
                                                data-{{$key}}="{{$value}}"
                                        @endforeach>
                                    </script>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://js.stripe.com/v3/"></script>
@endpush


