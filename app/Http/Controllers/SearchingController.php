<?php

namespace App\Http\Controllers;

use App\Models\BiddingHistory;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CarBrand;
use App\Models\CarCategory;
use App\Models\Page;
use App\Models\Vehicle;
use App\Models\VehicleDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchingController extends Controller
{
    public function filterVehicle(Request $request)
    {
        $pageSeo = Page::where('name', 'auction')->select('page_title','breadcrumb_image','breadcrumb_image_driver')->first();
        $search = $request->all();
        $vehiclePriceRange = isset($search['my_range'])?explode(";", $search['my_range']):'';
//        dd($request->all());
        $vehicles = Vehicle::with('details')
            ->when(!empty($search['name']), function ($q) use($search,$request){
                return $q->whereHas('details', function ($q2) use($search,$request){
                    return $q2->where('title','LIKE', "%$request->name%");
                });
            })
            ->when(!empty($search['brand']), function ($q) use ($search){
                return $q->where('brand_id', $search['brand']);
            })
            ->when(!empty($search['category']), function ($q) use ($search){
                return $q->where('category_id', $search['category']);
            })
            ->when(isset($search['status']) && $search['status'] == 1, function ($q) use ($search){

               return $q->whereHas('details', function ($q2) use($search){
                   return   $q2->where('sold_status', $search['status']);
                });
            })
            ->when(isset($search['status']) && $search['status'] == 2, function ($q) use ($search){

                return $q->whereHas('details', function ($q2) use($search){
                    return   $q2->where('sold_status', 0);
                });
            })
            ->when(!empty($vehiclePriceRange), function ($q) use ($vehiclePriceRange) {
                return $q->whereHas('details', function ($q2) use($vehiclePriceRange){
                    return $q2->whereBetween('price', $vehiclePriceRange);
                });

            })
            ->paginate(basicControl()->paginate) ;
        $data['maxAmount'] =  VehicleDetails::get()->max('price');
        $data['minAmount'] =  VehicleDetails::get()->min('price');
        $data['carBrand']  = CarBrand::where('status',1)->get();
        $data['CarCategory'] = CarCategory::where('status',1)->get();
        return view('themes.light.auction', compact('vehicles','pageSeo'),$data);
    }

    public function filterBiddingHistory(Request $request)
    {
        $search = $request;
        $biddingHistorys = BiddingHistory::with('vehicle')
            ->when(!empty($search->title),function ($q1)use($search){
                return $q1->whereHas('vehicle',function ($q2)use($search){
                   return $q2->with('details')->whereHas('details',function ($q3)use($search){
                       $q3->where('title','LIKE',"%$search->title%");
                    });
                });
            })
            ->when(isset($search->sold_status) && $search->sold_status == 1 ,function ($q1)use($search){
                return $q1->whereHas('vehicle',function ($q2)use($search){
                    return $q2->with('details')->whereHas('details',function ($q3)use($search){
                        return $q3->where('sold_status', $search->sold_status);
                    });
                });
            })
            ->when(isset($search->sold_status) && $search->sold_status == 2 ,function ($q1)use($search){
                return $q1->whereHas('vehicle',function ($q2)use($search){
                    return $q2->with('details')->whereHas('details',function ($q3)use($search){
                        return $q3->where('sold_status', 0);
                    });
                });
            })
            ->when(isset($search->win_status) && $search->win_status == 1,function ($query)use($search){
               return $query->where('wining_status',$search->win_status);
            })
            ->when(isset($search->win_status) && $search->win_status == 2,function ($query)use($search){
                return $query->where('wining_status',0);
            })

            ->when(!empty($search->category),function ($query)use($search){
                return $query->whereHas('vehicle',function ($subQuery)use($search){
                    return   $subQuery->where('category_id',$search->category);
                });
            })
            ->when(!empty($search->brand),function ($query)use($search){
                return $query->whereHas('vehicle',function ($subQuery)use($search){
                    return $subQuery->where('brand_id',$search->brand);
                });
            })
            ->where('user_id',Auth::user()->id)
            ->paginate(basicControl()->paginate);

        $data['categories'] =  CarCategory::get();
        $data['brands'] =  CarBrand::get();
        return view(template().'biddingHistory',compact('biddingHistorys'),$data);
    }

    public function filterListedVehicle(Request $request)
    {
        $user = Auth::user();
        if(!$user->plan){

            return abort(404);
        }
        $search = $request;
        $vehicles =  Vehicle::with('details')
            ->when(!empty($search->title),function ($query)use($search){
                return $query->whereHas('details',function ($subQuery)use($search){
                   return $subQuery->where('title','LIKE',"%$search->title%");
                });
            })
            ->when(!empty($search->category),function ($query)use($search){
                return $query->where('category_id',$search->category);
            })
            ->when(!empty($search->brand),function ($query)use($search){
                return $query->where('brand_id',$search->brand);
            })
            ->when(isset($search->sold_status) && $search->sold_status == 1, function ($q) use ($search){

                return  $q->whereHas('details', function ($q2) use($search){
                    return  $q2->where('sold_status', $search->sold_status);
                });
            })
            ->when(isset($search->sold_status) && $search->sold_status == 2, function ($q) use ($search){

                return $q->whereHas('details', function ($q2) use($search){
                    return  $q2->where('sold_status', 0);
                });
            })
            ->when(isset($search->release_status) && $search->release_status == 3 ,function ($query)use($search){
               return $query->where('release_status',0);
            })
            ->when(isset($search->release_status) && $search->release_status == 1 ,function ($query)use($search){
                return $query->where('release_status',$search->release_status);
            })
            ->when(isset($search->release_status) && $search->release_status == 2 ,function ($query)use($search){
                return $query->where('release_status',$search->release_status);
            })->where('user_id',Auth::user()->id)
            ->paginate(basicControl()->paginate);

            $data['categories'] =  CarCategory::get();
            $data['brands'] =  CarBrand::get();
            return view(template().'listedVehicle',compact('vehicles'),$data);
    }
    public function blogSearching(Request $request)
    {
        $blogs =  Blog::with('category','details')
        ->when(!empty($request->name), function ($query)use($request){
            return $query->whereHas('details',function ($subQuery)use($request){
                return $subQuery->where('title','LIKE',"%$request->name%");
            });
        })->paginate(basicControl()->paginate);
        $pageSeo = Page::where('name', 'blog')->select('page_title','breadcrumb_image','breadcrumb_image_driver')->first();
        $categorys = BlogCategory::where('status',1)->get();
        return view(template().'blogs',compact('blogs','categorys','pageSeo'));
    }
}
