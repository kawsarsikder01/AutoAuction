@extends($theme . 'layouts.app')
@section('title',trans($pageSeo->page_title??''))
@section('content')
<x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
 <!-- blog details  -->
 <section class="blog-section blog-details">
    <div class="container">
       <div class="row justify-content-between">
          <div class="col-lg-8">
             @foreach ($blogs as $blog)
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
                    <a href="{{route('blog.details',$blog->details->slug)}}" class="btn-custom arrow"><span>View More</span></a>
                    </div>
                </div>
             @endforeach
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
                   <form>
                      <div class="input-group">
                         <input type="text" class="form-control" placeholder="search Here" />
                         <button><i class="fal fa-search" aria-hidden="true"></i></button>
                      </div>
                   </form>
                </div>
                <div class="side-box">
                   <h4>categories</h4>
                   <ul class="links">
                    @foreach ($categorys as $category)
                    <li>
                       <a href="{{route('category.blogs',[$category->name,$category->id])}}">{{$category->name}} <span class="count">({{count($category->blogs)}})</span></a>
                    </li>
                   @endforeach
                   </ul>
                </div>
                <div class="side-box">
                   <h4>tags</h4>
                   <a href="" class="tag-item">Car</a>
                   <a href="" class="tag-item">Family Car</a>
                   <a href="" class="tag-item">Used car</a>
                   <a href="" class="tag-item">Motor</a>
                   <a href="" class="tag-item">Auction</a>
                   <a href="" class="tag-item">Ceremony</a>
                </div>
             </div>
          </div>
       </div>
    </div>
 </section>
 @include($theme . 'partials.footer')
@endsection
