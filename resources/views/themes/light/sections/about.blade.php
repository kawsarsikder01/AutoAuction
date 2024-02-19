<!-- about section -->
 <div class="about-section">
    <div class="container">
       <div class="row g-4 align-items-center">
          <div class="col-lg-6">
             <div class="img-box">
                 <img src="{{$about['single'] && $about['single']['media'] ? getFile($about['single']['media']->image->driver,$about['single']['media']->image->path):''}}" class="img-fluid" alt="" />
                <div class="shape-content">
                   <img src="{{asset($themeTrue.'img/icon/mercedes.png')}}" alt="" class="img-fluid mb-3" />
                   <h5>@lang('Total Raised')</h5>
                   <h4>@lang(currencyPosition($about['single']['total_raised_amount']??''))</h4>
                </div>
             </div>
          </div>
          <div class="col-lg-6">
             <div class="section-header">
                <h5>@lang($about['single']['heading']??'')</h5>
                <h2>@lang($about['single']['title']??'')</h2>
                <p>
                  {!! $about['single']['description']??'' !!}
                </p>

             </div>
          </div>
       </div>
    </div>
 </div>
