  <!-- testimonial section -->
  <section class="testimonial-section" style="background-image: url({{getFile($testimonial['single']['media']->image->driver,$testimonial['single']['media']->image->path)}});">
    <div class="overlay">
       <div class="container">
          <div class="row">
             <div class="col-12">
                <div class="section-header" overlay-text="Working Process">
                   <div class="box">
                      <h5>{{$testimonial['single']['title']}}</h5>
                   </div>
                   <div class="box">
                      <h2>{{$testimonial['single']['sub_title']}}</h2>
                      <p>
                        {{$testimonial['single']['text']}}
                      </p>
                   </div>
                </div>
             </div>
          </div>
          <div class="row g-4 g-lg-5">
             <div class="col">
                <div class="owl-carousel testimonials">
                  @foreach (collect($testimonial['multiple'])->toArray() as $item)
                  @php
                      $objectItem = (object) $item;
                  @endphp
                  <div class="item-box">
                     <div class="img-box">
                        <img src="{{getFile($objectItem->media->image->driver,$objectItem->media->image->path)}}" alt="" class="img-fluid" />
                     </div>
                     <div class="text-box">
                        <h4 class="mb-0">{{$objectItem->name}}</h4>
                        <b class="text-primary">{{$objectItem->title}}</b>
                        <p class="mt-4">
                           {{$objectItem->text}}
                        </p>
                     </div>
                     <i class="fa-thin fa-quote-right quote"></i>
                  </div>
                  @endforeach
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>