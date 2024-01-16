{{-- <x-banner-component heading="About Us" page="About Us"/> --}}
<!-- about section -->
 <div class="about-section">
    <div class="container">
       <div class="row g-4 align-items-center">
          <div class="col-lg-6">
             <div class="img-box">
                
                <div class="shape-content">
                   <img src="{{getFile($about['single']['media']->image->driver,$about['single']['media']->image->path)}}" alt="" class="img-fluid mb-3" />
                   <h5>@lang('Total Raised')</h5>
                   <h4>{{$about['single']['total_raised_amount']}}</h4>
                </div>
             </div>
          </div>
          <div class="col-lg-6">
             <div class="section-header">
                <h5>{{$about['single']['heading']}}</h5>
                <h2>{{$about['single']['title']}}</h2>
                <p>
                  {{$about['single']['description']}}
                </p>
                <ul class="list-unstyled">
                  @foreach (collect($about['multiple'])->toArray() as $item)
                     <li>
                        <i class="fa-light fa-check-double text-primary"></i> {{$item['option']}}
                     </li>
                  @endforeach
                </ul>
                
             </div>
          </div>
       </div>
    </div>
 </div>