
<section class="banner-section" style="background: url({{getFile($driver,$path)}}); background-size: cover;background-position: center right;">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <h2>{!! $page_title !!}</h2>
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('page')}}">@lang('Home')</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{!! $page_title !!}</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</section>
