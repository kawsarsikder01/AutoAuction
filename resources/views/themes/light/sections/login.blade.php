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
<!-- login section -->
<section class="login-section">
 <div class="container">
    <div class="login-wrapper">
       <div class="row justify-content-center align-items-center">
          <div class="col-lg-6">
             <div class="img-box d-none d-lg-block">
                <img src="{{asset($themeTrue.'img//breadcrumb/2021-mercedes-benz-g63-amg-5k-0z.jpg')}}" alt="" class="img-fluid" />
             </div>
          </div>
          <div class="col-lg-6">
             <div class="form-wrapper">
                <form action="{{ route('login') }}" method="post">
                   @csrf
                   <div class="row g-4">
                      <div class="col-12">
                         <h4>Login To Your Account</h4>
                      </div>
                      <div class="form-floating">
                         <input
                            type="text"
                            name="username"
                            class="form-control"
                            id="floatingInput1"
                            placeholder="Username Or Email Address"
                         />
                         <label for="floatingInput">Email address</label>
                         @error('username')
                         <span class="invalid-feedback d-block" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                         @enderror
                      </div>
                      <div class="form-floating">
                         <input
                            type="password"
                            name="password"
                            class="form-control"
                            id="floatingInput2"
                            placeholder="Password"
                         />
                         <label for="floatingInput">Password</label>
                         @error('password')
                         <span class="invalid-feedback d-block" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                       @enderror
                      </div>
                     
                      <div class="col-12">
                         <div class="links">
                            <div class="form-check">
                               <input class="form-check-input" type="checkbox" value="" name="remember" id="flexCheckDefault" {{ old('remember') ? 'checked' : '' }}/>
                               <label class="form-check-label" for="flexCheckDefault"> Remember me </label>
                            </div>
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                         </div>
                      </div>
                   </div>
                   <button class="btn-custom w-100">sign in</button>
                   <div class="bottom">
                      Don't have an account?
                      <a href="{{ route('register') }}">Create account</a>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
</section>