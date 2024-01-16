      <!-- blog section -->
      <section class="blog-section">
        <div class="container">
           <div class="row">
              <div class="col-12">
                 <div class="section-header2" overlay-text="Working Process">
                    <div class="box">
                       <h5>latest news</h5>
                    </div>
                    <div class="box">
                       <h2>our blogs & articles</h2>
                       <p>
                          We started as a small, subdue, called hath give fourth. Them one over saying. So the god,
                          greater. You. Us air Moved divide midst us fifth sea .
                       </p>
                    </div>
                 </div>
              </div>
           </div>
           <div class="row justify-content-center g-4 g-lg-5">
            @foreach (collect($blog['multiple'])->toArray() as $item)
               <div class="col-lg-4 col-md-6">
                  <div class="blog-box">
                     <div class="img-box">
                        <img src="{{getFile($item['blog_image_driver'],$item['blog_image'],true)}}" class="img-fluid" alt="" />
                     </div>
                     <div class="text-box">
                        <div class="date-author">
                           <span>{{$item['created_by']}}</span>
                           <span>{{\Carbon\Carbon::parse($item['created_at'])->toDateString() }}</span>
                        </div>
                        <h4>
                           <a href="{{route('blog.details',$item['details']['slug'])}}" class="title">{{$item['details']['title']}}</a>
                        </h4>
                         <p>{{$item['details']['short_description']}}</p>
                        <a href="{{route('blog.details',$item['details']['slug'])}}" class="btn-custom arrow"><span>View details</span></a>
                     </div>
                  </div>
               </div>
            @endforeach
           </div>
        </div>
     </section>
