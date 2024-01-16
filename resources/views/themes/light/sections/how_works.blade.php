<!-- how it works -->
<section class="how-it-works">
    <div class="container">
       <div class="row">
          <div class="col-12">
             <div class="section-header2" overlay-text="Working Process">
                <div class="box">
                   <h5>{{$how_works['single']['sub_heading']}}</h5>
                </div>
                <div class="box">
                   <h2>{{$how_works['single']['heading']}}</h2>
                   <p>
                     {{$how_works['single']['text']}}
                   </p>
                </div>
             </div>
          </div>
       </div>
       <div class="row g-4 g-lg-5 justify-content-center align-items-center">
          <div class="col-lg-3 item-box-left">
            @php
                $count = 0;
            @endphp
            @foreach (collect($how_works['multiple'])->toArray() as $item)
            @php
                $mid = (int) (count($how_works['multiple']) / 2);
            @endphp
               @if ($count < $mid)
                  <div class="item-box">
                  <div class="text">
                     <h3 class="index"> {{$count + 1}}.</h3>
                     <h4>{{$item['heading']}}</h4>
                     <p>
                       {{$item['text']}}
                     </p>
                  </div>
               </div>
               @endif
               @php
                   $count++;
               @endphp
            @endforeach
          </div>
          <div class="col-lg-6 text-center">
             <img src="{{getFile($how_works['single']['media']->image->driver,$how_works['single']['media']->image->path)}}" alt="" class="img-fluid" />
          </div>
          <div class="col-lg-3">
            @php
                $count = 0;
            @endphp
             @foreach (collect($how_works['multiple'])->toArray() as $item)
             @if ($count >= $mid)
               <div class="item-box">
                  <div class="text">
                     <h3 class="index">{{$count + 1}}.</h3>
                     <h4>{{$item['heading']}}</h4>
                     <p>
                        {{$item['text']}}
                     </p>
                  </div>
               </div>
             @endif
             @php
                 $count++;
             @endphp
             @endforeach
          </div>
       </div>
    </div>
 </section>