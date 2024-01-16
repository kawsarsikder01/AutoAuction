<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogDetails;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function blogDetails($slug)
    {
        
        $data['blogDetails'] = BlogDetails::with('blog')->where('slug', $slug)->first();
        $blogCategories = BlogCategory::get();
        $categoryId = $data['blogDetails']->blog->category_id;
        $category = BlogCategory::findOrFail($categoryId);
        $categoryBlogs = $category->blogs;
        return view('themes.light.blog_details',$data,compact('blogCategories','categoryBlogs'));
    }


}
