<!-- why-choose-us -->
<section class="why-choose-us">
    <div class="container">
       <div class="row">
          <div class="col-12">
             <div class="section-header2" overlay-text="Working Process">
                <div class="box">
                   <h5>{{$why_chose_us['single']['heading']??''}}</h5>
                </div>
                <div class="box">
                   <h2>{{$why_chose_us['single']['title']??''}}</h2>
                   <p>
                     {{$why_chose_us['single']['text']??''}}
                   </p>
                </div>
             </div>
          </div>
       </div>
       <div class="row g-4 g-lg-5">
          @foreach (collect($why_chose_us['multiple'])->toArray() as $key => $item)
          <div class="col-lg-4 col-md-6">
            <div class="item-box">
               <div class="icon">
                  <i class="{{$item['media']->icon}}"></i>
               </div>
               <div class="text">
                  <h4>{{$item['heading']}}</h4>
                  <p>
                     {{$item['text']}}
                  </p>
                  <h3 class="index text-stroke">{{$key+1}}</h3>
               </div>
            </div>
         </div>
          @endforeach

       </div>
    </div>
 </section>
