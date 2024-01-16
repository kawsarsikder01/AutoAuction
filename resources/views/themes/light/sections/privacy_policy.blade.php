{{-- <x-banner-component heading="{{$privacy_policy['single']['page_name']}}" page="{{$privacy_policy['single']['page_name']}}"/> --}}

 <!-- privacy policy -->
 <section class="privacy-policy">
    <div class="container">
       <div class="row">
          <div class="col">
             <div class="section_bottom">

                @foreach (collect($privacy_policy['multiple'])->toArray() as $item)
                    <h4>{{$item['heading']}}</h4>
                    <p>
                    {!! $item['text'] !!}
                    </p>
                @endforeach
             </div>
          </div>
       </div>
    </div>
 </section>
