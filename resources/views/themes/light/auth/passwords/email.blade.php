@extends($theme.'layouts.app')
@section('content')
<section class="banner-section" style=" padding: 250px 0 150px 0; position: relative;background: url({{asset($themeTrue.'img/breadcrumb/bugatti-wallpaperflare2.jpg')}});background-size: cover;background-repeat: no-repeat;background-position: center right; overflow: hidden;z-index: 1;">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <h2>Login</h2>
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Login</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</section>
<section class="login-section">
    <div class="container">
       <div class="login-wrapper">
          <div class="row justify-content-center align-items-center">
             <div class="col-lg-6">
                <div class="img-box d-none d-lg-block">
                   <img src="{{asset($themeTrue.'/img//breadcrumb/2021-mercedes-benz-g63-amg-5k-0z.jpg')}}" alt="" class="img-fluid" />
                </div>
             </div>
             <div class="col-lg-6">
                <div class="form-wrapper">
                   <form action="{{ route('password.email')}}" method="POST">
                     @csrf
                      <div class="row g-4">
                         <div class="col-12">
                            <h4>@lang('Forgot Password?')</h4>
                            <p>@lang("No worries, we'll send you reset instructions.")</p>
                         </div>
                            @if (session('status'))
                              <div class="alert alert-success" role="alert">
                                 {{ session('status') }}
                              </div>
                            @endif
                         <div class="form-floating">
                           <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="floatingInput">@lang('Email address')</label>
                            @error('email')
                              <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                         </div>
                      </div>
                      <button type="submit" class="btn-custom w-100 mt-4">@lang("Reset Password")</button>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
@endsection
{{-- @error('email') is-invalid @enderror --}}
{{-- value="{{ old('email') }}" --}}