<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\Language;
use App\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\CarCategory;

class AuctionController extends Controller
{
    use Upload;
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
        try {
            $defaultLanguage = Language::findOrFail($language);
            $carCategory = CarCategory::findOrFail($id);
            return view('admin.auctionManagement.category.edit',compact('defaultLanguage','carCategory'));
        }catch (\Exception $exception){
            abort(404);
        }

    }
    public function updateCategory(Request $request,$id)
    {
        try {

            $category = CarCategory::findOrFail($id);
            $request->validate([
                'name' => 'required|string'
            ]);
            $category->name = $request->name;
            $category->status = $request->status?1:0;
            $category->language_id =  $request->language_id;
            $category->update();
            return redirect()->route('admin.car.category')->with('success','Category Update Successfull');
        }catch (\Exception $exception){
            abort(404);
        }
    }
    public function deleteCategory($id)
    {
        try {
            $category = CarCategory::findOrFail($id);
            foreach($category->vehicles as $vehicle){
                $vehicle->biddingHistory()->delete();
                foreach ($vehicle->path_name as $image){
                    $this->fileDelete($vehicle->driver,$image);
                }
                $vehicle->details->delete();
                $vehicle->delete();
            }
            $category->delete();
            return back()->with('success', 'Category deleted successfully.');
        }catch (\Exception $exception){
            abort(404);
        }
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
        try {
            $defaultLanguage = Language::findOrFail($language);
            $brand = CarBrand::findOrFail($id);
            return view('admin.auctionManagement.brand.edit',compact('defaultLanguage','brand'));
        }catch (\Exception $exception){
            abort(404);
        }


    }
    public function updateBrand(Request $request,$id)
    {
        try {
            $brand = CarBrand::findOrFail($id);
            $request->validate([
                'name' => 'required'
            ]);
            $brand->name = $request->name;
            $brand->status = $request->status?1:0;
            $brand->language_id =  $request->language_id;
            $brand->update();
            return redirect()->route('admin.car.brand')->with('success','Category Update Successfull');
        }catch (\Exception $exception){
            abort(404);
        }

    }
    public function deleteBrand($id)
    {
        try {
            $brand = CarBrand::findOrFail($id);
            foreach ($brand->vehicles as $vehicle){
                $vehicle->biddingHistory()->delete();
                foreach ($vehicle->path_name as $image){
                    $this->fileDelete($vehicle->driver,$image);
                }
                $vehicle->details->delete();
                $vehicle->delete();
            }
            $brand->delete();
            return back()->with('success', 'Brand deleted successfully.');
        }catch (\Exception $exception){
            abort(404);
        }
    }
}
