
<section class="home-section" style="background-image: url({{$hero['single'] && $hero['single']['media']?getFile($hero['single']['media']->image->driver,$hero['single']['media']->image->path):''}});">
    <div class="container h-100">
       <div class="row h-100 align-items-center">
          <div class="col-lg-6">
             <div class="text-box">
                <h5 class="text-primary text-uppercase">{{$hero['single']['heading']??''}}</h5>
                <h1>{{$hero['single']['sub_heading']??''}}</h1>
                {{-- <h1>Buy Your Next Dream at <span class="text-">Auto Auction</span></h1> --}}
                <p class="text-white">
                  {!! $hero['single']['description']??'' !!}
                </p>
                <div class="d-flex align-items-center mt-5">
                   <button class="btn-custom"><span>@lang('Get started')</span></button>
                </div>
             </div>
          </div>
       </div>
    </div>
    <a href="#featureSection" class="scroll">@lang('Scroll')</a>
 </section>
