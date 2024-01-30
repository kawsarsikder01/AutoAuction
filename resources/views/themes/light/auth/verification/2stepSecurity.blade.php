@extends($theme.'layouts.app')
@section('title',$pageSeo->page_title??'')

@section('content')
    <x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
    <section id="about-us" class="about-page secbg-3 mt-5 mb-5">
        <div class="container">
            <div class="login-wrapper">
               <div class="row justify-content-center align-items-center">
                  <div class="col-lg-6">
                     <div class="img-box d-none d-lg-block">
                        <img src="{{getFile($pageSeo->breadcrumb_image_driver,$pageSeo->breadcrumb_image)}}" alt="" class="img-fluid" />
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-wrapper">
                        <form class="login-form" action="{{route('user.twoFA-Verify')}}"  method="post">
                            @csrf
                            <div class="signin">
                                <h3 class="title mb-30">@lang('2FA Code')</h3>
                                <div class="form-group mb-30">
                                    <input class="form-control" type="text" name="code" value="{{old('code')}}" placeholder="@lang('Code')" autocomplete="off">
                        
                                    @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                        
                                <div class="btn-area mt-4">
                                    <button class="btn-custom" type="submit"><span>@lang('Submit')</span></button>
                                </div>
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
