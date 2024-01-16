 <!-- brand section -->
 <section class="brand-section">
    <div class="container">
       <div class="row">
          <div class="col">
             <div class="owl-carousel brands">
               @foreach (collect($brand['multiple'])->toArray() as $item)
                  <img src="{{getFile($item['media']->image->driver,$item['media']->image->path)}}" alt="" />
               @endforeach
             </div>
          </div>
       </div>
    </div>
 </section>