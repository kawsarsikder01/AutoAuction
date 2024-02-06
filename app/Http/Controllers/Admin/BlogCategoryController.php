<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Language;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $defaultLanguage = Language::where('default_status', true)->first();
        $languages = Language::get();
        $blogCategory = BlogCategory::where('language_id',  $defaultLanguage->id)->get();
        return view('admin.blog_management.blog_category.index',compact('blogCategory','defaultLanguage','languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        return view('admin.blog_management.blog_category.create',compact('defaultLanguage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required | max:90',
        ]);
        $blogCategory = new BlogCategory;
        $blogCategory->name = $request->name;
        $blogCategory->language_id = $request->language_id;
        $blogCategory->status = $request->status? 1 : 0;
        $blogCategory->save();
        return redirect(route('admin.blogCategory'));
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,$language =NULL)
    {
        try{
            $language = Language::findOrFail($language);
            $blogCategory = BlogCategory::findOrFail($id);
            $defaultLanguage = Language::where('default_status', true)->first();
            return view('admin.blog_management.blog_category.create' , compact('blogCategory','language','defaultLanguage'));
        }catch (\Exception $exception){
            return view(template().'errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $blogCategory = BlogCategory::findOrFail($id);
            $blogCategory->name = $request->name;
            if($request->status){
                $blogCategory->status = 1;
            }else{
                $blogCategory->status = 0;
            }
            $blogCategory->update();
            return redirect(route('admin.blogCategory'));
        }catch (\Exception $exception){
            return view(template().'errors.404');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try{
            $blogCategory = BlogCategory::findOrFail($request->id);
            $blogCategory->delete();
            return redirect(route('admin.blogCategory'));
        }catch (\Exception $exception){
            return view(template().'errors.404');
        }

    }
}
