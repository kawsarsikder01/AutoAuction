@extends($theme . 'layouts.app')

@section('title',trans('Blog Details'))
@section('content')
<x-banner-component :pagetitle="optional($blogDetails->blog)->page_title??''" :path="$blogDetails->blog->breadcrumb_image??''" :driver="$blogDetails->blog->breadcrumb_image_driver??''"/>
<section class="blog-section blog-details">
    <div class="container">
       <div class="row justify-content-between">
          <div class="col-lg-8">
             <div class="blog-box">
                <div class="img-box">
                   <img src="{{getFile($blogDetails->blog->blog_image_driver,$blogDetails->blog->blog_image,true)}}" class="img-fluid" alt="" />
                </div>
                <div class="text-box">
                   <div class="date-author">
                      <span>{{$blogDetails->blog->created_by}}</span>
                      <span>{{\Carbon\Carbon::parse($blogDetails->blog->created_at)->toDateString() }}</span>
                   </div>
                   <h3>{{$blogDetails->title}}</h3>
                   <p>
                      {!! $blogDetails->description !!}
                   </p>
                   <div id="shareBlock"><h4>@lang('Share now :')</h4></div>
                </div>
             </div>
          </div>
          <div class="col-lg-3">
             <div class="side-bar">
                <div class="side-box search-box">
                    <form action="{{route('blog.search')}}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" placeholder="@lang('search Here')" />
                            <button><i class="fal fa-search" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
                <div class="side-box">
                   <h4>@lang('Related Posts')</h4>
                   @php $i = 0; @endphp
                   @foreach ($categoryBlogs as $key => $relatedBlog)
                       @if($relatedBlog->id ==$blogDetails->blog->id )
                           @php continue @endphp
                       @endif
                       @php $i++ ;@endphp
                       @if ($i == 4)
                          @break
                       @endif
                    <div class="side-blog-box">
                        <div class="img-box">
                        <img class="img-fluid" src="{{getFile($relatedBlog->blog_image_driver,$relatedBlog->blog_image,true)}}" alt="" />
                        </div>
                        <div class="text-box">
                        <span class="date">{{\Carbon\Carbon::parse($relatedBlog->created_at)->toDateString() }}</span>
                        <a href="{{route('blog.details',$relatedBlog->details->slug)}}" class="title">{{$relatedBlog->details->title}} </a>
                        </div>
                    </div>
                   @endforeach

                </div>
                <div class="side-box">
                   <h4>@lang('categories')</h4>
                   <ul class="links">
                    @foreach ($blogCategories as $blogCategorie)
                     <li>
                        <a href="{{route('category.blogs',[$blogCategorie->name,$blogCategorie->id])}}">{{$blogCategorie->name}} <span class="count">({{count($blogCategorie->blogs)}})</span></a>
                     </li>
                    @endforeach

                   </ul>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
@include($theme . 'sections.footer')
@endsection


@push('script')
    <script>
        $("#shareBlock").socialSharingPlugin({
            urlShare: window.location.href,
            description: $("meta[name=description]").attr("content"),
            title: $("title").text(),
        });
    </script>
@endpush
