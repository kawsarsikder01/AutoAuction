<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\AlphaDashWithoutSlashes;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogDetails;
use App\Models\Language;
use App\Models\BlogCategory;
use App\Traits\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    use Upload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        $data['languages'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();

        $data['blogs'] = Blog::with(['category', 'details' => function ($query) use ($defaultLanguage) {
            $query->where('language_id', $defaultLanguage->id);
        }])
            ->orderBy('id', 'desc')
            ->paginate(basicControl()->paginate);
        return view('admin.blog_management.blog.index',$data,compact('defaultLanguage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->get();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        return view('admin.blog_management.blog.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_category,id',
            'title' => 'required|string|min:3|max:200',
            'slug' => 'required|string|min:3|max:200|alpha_dash|unique:blog_details,slug',
            'description' => 'required|string|min:3|max:10000',
            'description_image' => 'required|mimes:png,jpg,jpeg|max:5000',
            'short_description' => 'required | string | max:20000'
        ]);

        try {
            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null,null, 'avif',60);
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('breadcrumb_image')){
                $breadcrumbImage = $this->fileUpload($request->breadcrumb_image, config('filelocation.blog.breadcrumbImage.path'), null, null, 'avif', 60);
                throw_if(empty($breadcrumbImage['path']), 'Description image could not be uploaded.');
            }

            $response = Blog::create([
                'category_id' => $request->category_id,
                'created_by'  => Auth::user()->name,
                'blog_image' => $descriptionImage['path'] ?? null,
                'blog_image_driver' => $descriptionImage['driver'] ?? null,
                'status' => $request->status,
                'breadcrumb_status' => $request->breadcrumb_status,
                'breadcrumb_image' => $breadcrumbImage['path'] ?? null,
                'breadcrumb_image_driver' => $breadcrumbImage['driver'] ?? null,
            ]);

            throw_if(!$response, 'Something went wrong while storing blog data. Please try again later.');


            $response->details()->create([
                "title" => $request->title,
                "slug" => $request->slug,
                'language_id' => $request->language_id,
                'description' => $request->description,
                'short_description' => $request->short_description
            ]);

            return redirect(route('admin.blogs'))->with('success', 'Blog saved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id , $language = NULL)
    {
        $blog = Blog::with(["details" => function ($query) use ($language) {
            $query->where('language_id', $language);
        }])->where('id', $id)->firstOr(function () {
            throw new \Exception('Blog not found');
        });
        $data['pageEditableLanguage'] = Language::where('id', $language)->select('id', 'name', 'short_name')->first();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['blogCategory'] = BlogCategory::orderBy('id', 'desc')->get();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
            return view('admin.blog_management.blog.edit',$data, compact('blog','language'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::with(['details'=>function ($query)use($request) {
            $query->where('language_id',$request->language_id);
        }])->findOrFail($id);


        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_category,id',
            'title' => 'required|string|min:3|max:200',
            'slug' => ['required', 'min:1', 'max:100',
                new AlphaDashWithoutSlashes(),
                Rule::unique('blog_details', 'slug')->ignore(optional($blog->details)->id),
                Rule::notIn(['login', 'register', 'signin', 'signup', 'sign-in', 'sign-up'])
            ],
            'description' => 'nullable|string|min:3',
            'description_image' => 'nullable|mimes:png,jpg,jpeg|max:50000',
        ]);

        try {
            DB::beginTransaction();
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });
            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, null, 'avif', 60, $blog->blog_image,$blog->blog_image_driver);
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('breadcrumb_image')){
                $breadcrumbImage = $this->fileUpload($request->breadcrumb_image, config('filelocation.blog.path'), null, null, 'avif', 60, $blog->breadcrumb_image??null,$blog->breadcrumb_image_driver??null);
                throw_if(empty($breadcrumbImage['path']), 'Description image could not be uploaded.');
            }
            $blog->created_by = Auth::user()->id;
            $blog->category_id = $request->category_id;
            $blog->breadcrumb_status = $request->breadcrumb_status;
            $blog->blog_image = $descriptionImage['path']??$blog->blog_image;
            $blog->blog_image_driver = $descriptionImage['driver']??$blog->blog_image_driver;
            $blog->breadcrumb_image = $breadcrumbImage['path']??$blog->breadcrumb_image;
            $blog->breadcrumb_image_driver = $breadcrumbImage['driver']??$blog->breadcrumb_image_driver;
            $blog->save();
            $blog->details()->updateOrCreate([
                'language_id' => $request->language_id,
            ],
                [
                    'slug' => $request->slug,
                    "title" => $request->title,
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                ]
            );
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating blog details.');
        }

        return back()->with('success', 'Blog saved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blog = Blog::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog data found.');
            });
            $this->
            $blog->details()->delete();
            $blog->delete();
            return redirect()->back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public  function blogSeo($id)
    {

        try {
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });
            return view('admin.blog_management.blog.seo',compact('blog'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public  function  seoUpdate(Request $request,$id)
    {
        $request->validate([
            'page_title' => 'required|string|min:3|max:100',
            'meta_title' => 'required|string|min:3|max:100',
            'meta_keywords' => 'required|array',
            'meta_keywords.*' => 'required|string|min:1|max:300',
            'meta_description' => 'required|string|min:1|max:300',
            'meta_image' => 'sometimes|required|mimes:jpeg,png,jpeg|max:2048'
        ]);



        $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
            throw new \Exception('Blog not found');
        });

        if ($request->hasFile('meta_image')) {
            try {
                $image = $this->fileUpload($request->meta_image, config('filelocation.pageSeo.path'),null,null, 'avif', 60,  $blog->meta_image_driver, $blog->meta_image, );
                if ($image) {
                    $pageSEOImage = $image['path'];
                    $pageSEODriver = $image['driver'] ?? 'local';
                }
            } catch (\Exception $exp) {
                return back()->with('warning', 'Meta image could not be uploaded.');
            }
        }

        $blog->update([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'meta_image' => $pageSEOImage ?? $blog->meta_image,
            'meta_image_driver' => $pageSEODriver ?? $blog->meta_image_driver,
            'page_title' => $request->page_title,
        ]);



        return back()->with('success', 'Seo has been updated.');
    }
   public function filterBlog(Request $request)
   {
       $blogs = Blog::with('details')
           ->when(!empty($request->title),function ($query)use($request){
               return $query->whereHas('details',function ($subQuery)use($request){
                   return $subQuery->where('title','LIKE',"%$request->title%");
               });
           })
           ->when(isset($request->status) && $request->status == 1,function ($query)use($request){
               return $query->where('status',$request->status);
           })
           ->when(isset($request->status) && $request->status == 0,function ($query)use($request){
               return $query->where('status',$request->status);
           })->paginate(basicControl()->paginate);
       $defaultLanguage = Language::where('default_status', true)->first();
       $data['languages'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
       return view('admin.blog_management.blog.index',$data,compact('defaultLanguage','blogs'));
   }
}
