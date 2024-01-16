<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\CarCategory;

class AuctionController extends Controller
{
    //  Category  section

    public function category()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        $languages = Language::get();
        $carCategories = CarCategory::where('language_id',  $defaultLanguage->id)->get();
        return view('admin.auctionManagement.category.index',compact('carCategories','defaultLanguage','languages'));
    }

    public function  createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required | string'
        ]);
        CarCategory::create([
            'name' => $request->name,
            'status' => $request->status?1:0,
            'language_id' => $request->language_id
        ]);
        return redirect()->route('admin.car.category')->with('success','Your Category Create Successfull');
    }
    public function editCategory($id,$language)
    {
        $defaultLanguage = Language::findOrFail($language);
        $carCategory = CarCategory::findOrFail($id);
        return view('admin.auctionManagement.category.edit',compact('defaultLanguage','carCategory'));

    }
    public function updateCategory(Request $request,$id)
    {
        $category = CarCategory::findOrFail($id);
        $category->name = $request->name;
        $category->status = $request->status?1:0;
        $category->language_id =  $request->language_id;
        $category->update();
        return redirect()->route('admin.car.category')->with('success','Category Update Successfull');
    }
    public function deleteCategory($id)
    {
        $category = CarCategory::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }


    //  Brand section

    public function brand()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        $languages = Language::get();
        $brand = CarBrand::where('language_id',  $defaultLanguage->id)->get();
        return view('admin.auctionManagement.brand.index',compact('brand','defaultLanguage','languages'));
    }

    public function  createBrand(Request $request)
    {
        $request->validate([
            'name' => 'required | string'
        ]);
        CarBrand::create([
            'name' => $request->name,
            'status' => $request->status?1:0,
            'language_id' => $request->language_id
        ]);
        return redirect()->route('admin.car.brand')->with('success','Your Brand Create Successfull');
    }
    public function editBrand($id,$language)
    {
        $defaultLanguage = Language::findOrFail($language);
        $brand = CarBrand::findOrFail($id);
        return view('admin.auctionManagement.brand.edit',compact('defaultLanguage','brand'));

    }
    public function updateBrand(Request $request,$id)
    {
        $brand = CarBrand::findOrFail($id);
        $brand->name = $request->name;
        $brand->status = $request->status?1:0;
        $brand->language_id =  $request->language_id;
        $brand->update();
        return redirect()->route('admin.car.brand')->with('success','Category Update Successfull');
    }
    public function deleteBrand($id)
    {
        $brand = CarBrand::findOrFail($id);
        $brand->delete();
        return back()->with('success', 'Brand deleted successfully.');
    }
}
