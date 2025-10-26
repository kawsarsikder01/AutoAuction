@extends($theme.'layouts.app')
@section('title',trans($pageSeo->page_title??''))
@section('content')
<x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
          <!-- login section -->
          <section class="login-section">
            <div class="container">
               <div class="login-wrapper">
                  <div class="row justify-content-center align-items-center">
                     <div class="col-lg-6">
                        <div class="img-box d-none d-lg-block">

                           <img src="{{$loginContent->first()?getFile($loginContent->first()->content->media->image->driver,$loginContent->first()->content->media->image->path):''}}" alt="" class="img-fluid" />
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-wrapper">
                           <form action="{{ route('login') }}" method="post">
                              @csrf
                              <div class="row g-4">
                                 <div class="col-12">
                                    <h4>@lang($loginContent->first()->description->heading??'')</h4>
                                 </div>
                                 <div class="form-floating">
                                    <input
                                       type="text"
                                       name="username"
                                       class="form-control"
                                       id="floatingInput1"
                                       placeholder="@lang('Enter Your Username')"
                                       autocomplete="off"
                                    />
                                    <label for="floatingInput">@lang('Username')</label>
                                    @error('username')
                                    <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                 </div>
                                 <div class="form-floating">
                                    <input
                                       type="password"
                                       name="password"
                                       class="form-control"
                                       id="floatingInput2"
                                       placeholder="@lang('Password')"
                                       autocomplete="off"
                                    />
                                    <label for="floatingInput">@lang('Password')</label>
                                     <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                                 </div>
                                  @error('password')
                                  <span class="invalid-feedback d-block" role="alert">
                                        {{ $message }}
                                    </span>
                                  @enderror

                                  @if($basicControl->manual_recaptcha === 1 && $basicControl->reCaptcha_status_login === 1)
                                      <div class="form-floating">

                                          <input type="text"       tabindex="2"
                                                 class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                                 name="captcha" id="captcha" autocomplete="off"
                                                 placeholder="@lang('Enter Captcha')" >
                                          <label for="floatingInput">@lang('Captcha')</label>

                                          @error('captcha')
                                          <span class="invalid-feedback">{{ $message }}</span>
                                          @enderror
                                      </div>

                                      <div class="mt-4">
                                          <div class="input-group captcha-group input-group-merge manualRecaptchaImage" data-hs-validation-validate-class>
                                              <img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image' >
                                              <a class="input-group-append input-group-text manualRecaptchaIcon"
                                                 href='javascript: refreshCaptcha();'>
                                                  <i class="fa-solid fa-rotate-right"></i>
                                              </a>
                                          </div>
                                      </div>
                                  @endif

                                  @if(basicControl()->google_user_login_recaptcha_status && basicControl()->google_recaptcha)
                                      <div class="row mt-4">
                                          <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
                                               data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                          @error('g-recaptcha-response')
                                             <span class="invalid-feedback d-block text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                          @enderror
                                      </div>
                                  @endif
                                 <div class="col-12">
                                    <div class="links">
                                       <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="" name="remember" id="flexCheckDefault" {{ old('remember') ? 'checked' : '' }}/>
                                          <label class="form-check-label" for="flexCheckDefault"> @lang('Remember me') </label>
                                       </div>
                                       <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                    </div>
                                 </div>
                              </div>
                              <button class="btn-custom w-100">@lang('sign in')</button>
                              <div class="bottom">
                                 @lang("Don't have an account?")
                                 <a href="{{ route('register') }}">@lang('Create account')</a>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
@include($theme . 'sections.footer')
@endsection
@push('js-lib')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
@push('script')
    <script>
        'use strict';
        function refreshCaptcha(){
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0,img.src.lastIndexOf("?")
            )+"?rand="+Math.random()*1000;
        }


        $(document).ready(function (){
            $('#togglePassword').on('click',function (){
                let currentType =  $('#floatingInput2').attr('type');
                if (currentType === "password"){
                    $('#floatingInput2').attr('type','text');
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                }else{
                    $('#floatingInput2').attr('type','password');
                    $(this).addClass('fa-eye-slash');
                    $(this).removeClass('fa-eye');
                }
            });
        })
    </script>
@endpush
