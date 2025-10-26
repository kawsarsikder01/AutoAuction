@extends($theme.'layouts.user')
@section('title',__('2 Step Security'))

@section('content')

    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="row">
                    @if(auth()->user()->two_fa)
                    <div class="col-lg-6 col-md-6 mb-3">
                        <div class="card text-center search-bar">
                            <div class="card-header bg-white d-flex justify-content-between">
                                <h5 class="card-header-title mt-2">@lang('Two Factor Authenticator')</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#regenerateModal" class="btn-custom">@lang("Regenerate")</button>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" value="{{$secret}}"
                                           class="form-control" id="referralURL"
                                           readonly>
                                    <span class="input-group-text" id="copyBoard" onclick="copyFunction()"><i
                                            class="fa fa-copy"></i></span>
                                </div>

                                <div class="form-group mx-auto text-center">
                                    <img class="w-40 mx-auto qrCodeImage"
                                         src="https://quickchart.io/chart?cht=qr&chs=150x150&chl={{$qrCodeUrl}}">
                                </div>

                                <div class="form-group mx-auto text-center mt-3">
                                    <a href="javascript:void(0)" class="w-100 btn-custom"
                                       data-bs-toggle="modal"
                                       data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @else
                        <div class="col-lg-6 mb-3" >
                            <div class="card search-bar text-center br-4">
                                <div class="card-header bg-white d-flex justify-content-between">
                                    <h5 class="card-header-title mt-2">@lang('Two Factor Authenticator')</h5>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#regenerateModal" class="btn-custom">@lang("Regenerate")</button>
                                </div>
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <input type="text" value="{{$secret}}"
                                               class="form-control form-control-lg bg-transparent" id="referralURL"
                                               readonly>
                                        <span class="input-group-text cursor-pointer" id="basic-addon2" onclick="copyFunction()"><i
                                                class="fa fa-copy cursor-pointer"></i></span>
                                    </div>

                                    <div class="form-group mx-auto text-center">
                                        <img class="w-40 mx-auto qrCodeImage"
                                             src="https://quickchart.io/chart?cht=qr&chs=150x150&chl={{$qrCodeUrl}}">
                                    </div>

                                    <div class="form-group mx-auto text-center mt-3">
                                        <a href="javascript:void(0)" class="btn-custom"
                                           data-bs-toggle="modal"
                                           data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                    <div class="col-lg-6 mb-3">
                        <div class="card text-center search-bar" id="googleAuthenticator">
                            <div class="card-header bg-white">
                                <h5>@lang('Google Authenticator')</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-uppercase my-3">@lang('Use Google Authenticator to Scan the QR code  or use the code')</h6>
                                <p class="p-2">@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                                <a class="mt-3 btn-custom"
                                   href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                   target="_blank">@lang('DOWNLOAD APP')</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enable Modal -->
    <div class="modal fade user-modal" id="enableModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your OTP')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.twoStepEnable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-box col-md-12">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code"
                                   placeholder="@lang('Enter Google Authenticator Code')" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn-custom">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Disable +Modal -->
    <div class="modal fade user-modal" id="disableModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Verify Your OTP to Disable')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('user.twoStepDisable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="input-box col-md-12">
                            <input type="password" class="form-control" name="password"
                                   placeholder="@lang('Enter Your Password')" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn-custom">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Regenerate Modal -->
    <div class="modal fade" id="regenerateModal" tabindex="-1" aria-labelledby="regenerateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="regenerateModalLabel">@lang('Re-generate Confirmation')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{route('user.twoStepRegenerate')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @lang("Are you want to Re-generate Authenticator ?")
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">@lang('No')</button>
                        <button class="btn-custom" type="submit">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        #googleAuthenticator{
           min-height: 418px !important;
            /*align-items: center;*/
        }
         #googleAuthenticator .card-body{
             display: flex;
             flex-direction: column;
             justify-content: center;
             align-items: center;
          }
    </style>
@endpush


@push('script')
    <script>
        function copyFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush

