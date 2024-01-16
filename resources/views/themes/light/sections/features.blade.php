 <!-- feature section -->
 <section id="featureSection" class="feature-section">
    <div class="container">
       <div class="row">
          <div class="col-12">
             <div class="section-header" overlay-text="Working Process">
                <h5>{{$features['single']['heading']}}</h5>
                <h2>{{$features['single']['sub_heading']}}</h2>
                <p>
                   {{$features['single']['description']}}
                </p>
             </div>
          </div>
       </div>
       <div class="row g-4 g-lg-5">
          @foreach (collect($features['multiple'])->toArray() as $item)
          @php
             $objectItem = (object) $item
          @endphp
          <div class="col-lg-3 col-md-6">
            <div class="item-box">
               <div class="icon">
                  <i class="{{$objectItem->media->icon}}"></i>
               </div>
               <div class="text">
                  <h4>{{$objectItem->heading}}</h4>
                  <p>
                     {{$objectItem->text}}
                  </p>
               </div>
            </div>
         </div>
             
          @endforeach
          
       </div>
    </div>
 </section>
