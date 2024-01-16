@extends('themes.light.layouts.app')
@section('title',trans($pageSeo->page_title??''))
@section('content')
<x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>>
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
                          {{-- <div class="col-md-6">
                             <select class="form-select" id="countrycode" aria-label="Floating label select example">
                                <option selected value="1">+880</option>
                                <option value="2">+330</option>
                                <option value="3">+420</option>
                             </select>
                          </div> --}}
                          {{-- <div class="col-md-6 form-floating">
                             <input type="number" class="form-control" id="phone" placeholder="name@example.com" />
                             <label for="phone">Phone Number</label>
                          </div> --}}
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
                             <i class="fal fa-eye" id="togglePassword"></i>
                             @error('password')
                             <span class="invalid-feedback d-block" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                          <div class="col-md-12 form-floating">
                           <input type="password" name="password_confirmation" class="form-control" id="id_password" placeholder="Password" />
                           <label for="id_password">@lang('Confirm Password')</label>
                           <i class="fal fa-eye" id="togglePassword"></i>
                           @error('password_confirmation')
                           <span class="invalid-feedback d-block" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror
                        </div>
                          {{-- <div class="col-12">
                             <div class="links">
                                <div class="form-check">
                                   <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                   <label class="form-check-label" for="flexCheckDefault">
                                      I Agree with the Terms & conditions
                                   </label>
                                </div>
                             </div>
                          </div> --}}
                       </div>
                       <button class="btn-custom w-100">@lang('Create Account')</button>
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
@include($theme . 'partials.footer')
@endsection

@push('js-lib')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

