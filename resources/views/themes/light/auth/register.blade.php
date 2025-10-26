@extends('themes.light.layouts.app')
@section('title',trans($pageSeo->page_title??''))
@section('content')
<x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
    <!-- login section -->
    <section class="login-section">
        <div class="container">
           <div class="row justify-content-center align-items-center">
              <div class="col-lg-7">
                 <div class="register-form-wrapper">
                    <form action="{{ route('register') }}" method="post">
                     @csrf
                       <div class="row g-4">
                          <div class="col-12">
                             <h4>@lang('Create An Account')</h4>
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="text" name="first_name" class="form-control" id="fname" placeholder="@lang('First Name')" />
                             <label for="fname">@lang('First Name')</label>
                             @error('first_name')
                                <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="text" name="last_name" class="form-control" id="last_name" placeholder="@lang('Last Name')" />
                             <label for="last_name">@lang('Last Name')</label>
                             @error('last_name')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="email" name="email" class="form-control"  id="email" placeholder="@lang('Enter Your Email Address')" />
                             <label for="email">@lang('Email address')</label>
                             @error('email')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="text" name="username" class="form-control" id="username" placeholder="@lang('Enter Your Username')" />
                             <label for="username">@lang('Username')</label>
                             @error('username')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-12 form-floating">
                             <input type="password" name="password" class="form-control" id="id_password" placeholder="@lang('Password')" />
                             <label for="id_password">@lang('Password')</label>
                              <i class="fa-regular fa-eye-slash" id="togglePassword"></i>

                          </div>
                           @error('password')
                           <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                           @enderror
                          <div class="col-md-12 form-floating">
                           <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="@lang('Confirm Password')" />
                           <label for="confirmPassword">@lang('Confirm Password')</label>
                              <i class="fa-regular fa-eye-slash" id="confirmTogglePassword"></i>
                           @error('password_confirmation')
                           <span class="invalid-feedback d-block" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                        </div>
                           @if($basicControl->manual_recaptcha === 1 && $basicControl->reCaptcha_status_login === 1)
                               <div class="form-floating">

                                   <input type="text"       tabindex="2"
                                          class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                          name="captcha" id="captcha" autocomplete="off"
                                          placeholder="Enter Captcha" >
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
                       </div>
                       <button class="btn-custom w-100 mt-4">@lang('Create Account')</button>
                       <div class="bottom">
                          @lang('Already have an account?')
                          <a href="{{ route("login") }}">@lang('Login here')</a>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
     </section>
    <!-- End Contact Section -->
@include($theme . 'sections.footer')
@endsection
@push('js-lib')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
@push('script')
    <script>
        $(document).ready(function (){
            $('#togglePassword').on('click',function (){
               let currentType =  $('#id_password').attr('type');
               if (currentType === "password"){
                   $('#id_password').attr('type','text');
                   $(this).removeClass('fa-eye-slash');
                   $(this).addClass('fa-eye');
               }else{
                   $('#id_password').attr('type','password');
                   $(this).addClass('fa-eye-slash');
                   $(this).removeClass('fa-eye');
               }
            });
            $('#confirmTogglePassword').on('click',function (){
                let currentType =  $('#confirmPassword').attr('type');
                if (currentType === "password"){
                    $('#confirmPassword').attr('type','text');
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                }else{
                    $('#confirmPassword').attr('type','password');
                    $(this).addClass('fa-eye-slash');
                    $(this).removeClass('fa-eye');
                }
            })
        })
    </script>
@endpush

