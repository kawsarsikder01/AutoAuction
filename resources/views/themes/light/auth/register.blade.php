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
                             <input type="text" name="first_name" class="form-control" id="fname" placeholder="First Name" />
                             <label for="fname">First Name</label>
                             @error('first_name')
                                <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="text" name="last_name" class="form-control" id="lname" placeholder="name@example.com" />
                             <label for="lname">Last Name</label>
                             @error('last_name')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="email" name="email" class="form-control"  id="email" placeholder="name@example.com" />
                             <label for="email">@lang('Email address')</label>
                             @error('email')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-6 form-floating">
                             <input type="text" name="username" class="form-control" id="username" placeholder="name@example.com" />
                             <label for="username">@lang('Username')</label>
                             @error('username')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-12 form-floating">
                             <input type="password" name="password" class="form-control" id="id_password" placeholder="Password" />
                             <label for="id_password">@lang('Password')</label>
                              <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                             @error('password')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-12 form-floating">
                           <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="Password" />
                           <label for="confirmPassword">@lang('Confirm Password')</label>
                              <i class="fa-regular fa-eye-slash" id="confirmTogglePassword"></i>
                           @error('password_confirmation')
                           <span class="invalid-feedback d-block" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                        </div>
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

