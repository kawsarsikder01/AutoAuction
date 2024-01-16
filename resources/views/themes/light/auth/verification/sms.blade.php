@extends($theme.'layouts.app')
@section('title',$page_title)

@section('content')
<section class="banner-section" style=" padding: 250px 0 150px 0; position: relative;background: url({{asset($themeTrue.'img/breadcrumb/bugatti-wallpaperflare2.jpg')}});background-size: cover;background-repeat: no-repeat;background-position: center right; overflow: hidden;z-index: 1;">
    <div class="container">
       <div class="row">
          <div class="col-12">
             <h2>SMS Verification</h2>
             <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                   <li class="breadcrumb-item active" aria-current="page">SMS Verification</li>
                </ol>
             </nav>
          </div>
       </div>
    </div>
 </section>
    <section id="about-us" class="login_signup_page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-block py-5">
                        <form class="login-form" action="{{route('user.smsVerify')}}"  method="post">
                            @csrf
                            <div class="signin">
                                <h3 class="title mb-30">@lang($page_title)</h3>
                                <div class="form-group mb-30">
                                    <input class="form-control" type="text" name="code" value="{{old('code')}}" placeholder="@lang('Code')" autocomplete="off">

                                    @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>

                                <div class="btn-area">
                                    <button class="btn btn-primary mt-3" type="submit"><span>@lang('Submit')</span></button>
                                </div>

                                <div class="login-query mt-30 text-center">
                                    <p>@lang('Didn\'t get Code? Click to') <a href="{{route('user.resendCode')}}?type=mobile"  class="text-info"> @lang('Resend code')</a></p>
                                    @error('resend')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
