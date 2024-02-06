@extends($theme . 'layouts.app')
@section('title',trans($pageSeo->page_title??''))
@section('content')
<x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
 <!-- blog details  -->
 <section class="blog-section blog-details">
    <div class="container">
       <div class="row justify-content-between">
          <div class="col-lg-8">
             @forelse ($blogs as $blog)
                <div class="blog-box">
                    <div class="img-box">
                    <img src="{{getFile($blog->blog_image_driver,$blog->blog_image)}}" class="img-fluid" alt="" />
                    </div>
                    <div class="text-box">
                    <div class="date-author">
                        <span>{{$blog->created_by}}</span>
                        <span>{{\Carbon\Carbon::parse($blog->created_at)->toDateString() }}</span>
                    </div>
                    <h3>{{$blog->details->title}}</h3>
                    <p>
                       {{$blog->details->short_description}}
                    </p>
                    <a href="{{route('blog.details',$blog->details->slug)}}" class="btn-custom arrow"><span>@lang('View More')</span></a>
                    </div>
                </div>
              @empty
                  <div class="text-center p-4">
                      <img  class="dataTables-image mb-3 w-50"
                            src="{{ asset($themeTrue.'img/img/no_data_found.jpg') }}"
                            alt="Image Description">
                      <p class="mb-0">@lang("No Blog Found")</p>
                  </div>
             @endforelse
             <!-- pagination -->
             <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-4">
                    {{ $blogs->appends($_GET)->links($theme.'partials.pagination') }}
                </ul>
             </nav>
          </div>
          <div class="col-lg-3">
             <div class="side-bar">
                <div class="side-box search-box">
                   <form action="{{route('blog.search')}}" method="get">
                      <div class="input-group">
                         <input type="text" class="form-control" name="name" placeholder="search Here" />
                         <button><i class="fal fa-search" aria-hidden="true"></i></button>
                      </div>
                   </form>
                </div>
                <div class="side-box">
                   <h4>@lang('categories')</h4>
                   <ul class="links">
                    @foreach ($categorys as $category)
                    <li>
                       <a href="{{route('category.blogs',[$category->name,$category->id])}}">{{$category->name}} <span class="count">({{count($category->blogs)}})</span></a>
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
