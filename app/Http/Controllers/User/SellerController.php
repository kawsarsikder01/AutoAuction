<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Report;
use App\Traits\Notify;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Models\CarCategory;
use App\Models\CarBrand;
use App\Traits\Upload;
use App\Models\Vehicle;
use App\Models\VehicleDetails;
use Illuminate\Support\Facades\Auth;
use App\Rules\noOfMaxImg;

class SellerController extends Controller
{
    use Upload;
    use Notify;
    public function index()
    {
        $category = CarCategory::where('status',1)->get();
        $brand = CarBrand::where('status',1)->get();
        return view('themes.light.user.sell_your_vehicle.create',compact('category','brand'));
    }
    public function maximumListingValidation()
    {
        $user =  Auth::user();
       $maximumListing = $user->plan->number_of_listing;
       $totalListed = $user->total_listed_car ;
        if($maximumListing > $totalListed){
           return true;
        }else{
            return false;
        }
    }
    public function store(Request $request)
    {
        $user =  Auth::user();
        $maximumListing = $user->plan->number_of_listing;
       $request->validate([
        'title' => 'required | string | max:100',
        'vehicle_type' => 'required | string | max:150',
        'engine_type' => 'required | string | max:150',
        'power' => 'required | string | max:150',
        'torque' => 'required | string | max:150',
        'displacement' => 'required | string | max:150',
        'transmission' => 'required | string | max:150',
        'testResult' => 'required | string | min:5 | max:500',
        'dimensions' => 'required | string | min:10 | max:500',
        'shortDescription' => 'required | string | min:10 | max:1000',
        'description' => 'required | string | min:20 | max:2000',
        'price' => 'required | numeric',
        'auction_ending_date' => 'required | date_format:Y-m-d',
        'brand_id' => 'required',
        'category_id' => 'required',
        'images' => 'required',
        'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5000',new noOfMaxImg($request->images ? count($request->images):0)],
       ]);

        if (!$this->maximumListingValidation($user->id)) {
           return back()->with('warning', "You Can not post more than $maximumListing Vehicle");
        }


        $path = null;
       try{
            if($request->file('images')){
                $driver = array();
                $path = array();
                foreach( $request->images as $image){
                    $image = $this->fileUpload($image, config('filelocation.carImage.path'), null,null, 'avif',60);
                    if($image){
                        $path[] = $image['path'];
                        $driver = $image['driver'];
                    }else{
                        throw new Exception( 'Image could not be uploaded.',empty($image['path']));
                    }
                }
            }
            $vehicle = new Vehicle();
            $vehicle->path_name = $path;
            $vehicle->driver =  $driver ?? null;
            $vehicle->user_id  = $user->id;
            $vehicle->category_id  = $request->category_id;
            $vehicle->brand_id = $request->brand_id;
            $vehicle->plan_id = $user->plan->id;
            $vehicle->save();
            $vehicle->details()->create([
                    'title' => $request->title,
                    'vehicle_type' => $request->vehicle_type,
                    'engine_type' => $request->engine_type,
                    'power' => $request->power,
                    'torque' => $request->torque,
                    'displacement' => $request->displacement,
                    'transmission' => $request->transmission,
                    'test_result' => $request->testResult,
                    'dimension' => $request->dimensions,
                    'short_description' => $request->shortDescription,
                    'description' => $request->description,
                    'price' => $request->price,
                    'auction_ending_date' => $request->auction_ending_date,
            ]);
            $user->total_listed_car = $user->total_listed_car + 1;
            $user->update();

            return back()->with('success','Your Vehicle  add succeefully');
       }catch(Exception $error){
        return back()->with('error', $error->getMessage());
       }
    }

    public function listedVehicle()
    {
        $user = Auth::user();
        if(!$user->plan){
            return abort(404);
        }
        $vehicles = Vehicle::with('details')->where('user_id',$user->id)->paginate(basicControl()->paginate);
        $data['categories'] =  CarCategory::get();
        $data['brands'] =  CarBrand::get();
        return view(template().'listedVehicle',compact('vehicles'),$data);
    }

    public function  edit($id)
    {
        $vehicle = Vehicle::with('details')->find($id);
        if($vehicle->user_id != Auth::user()->id){
            return abort(404);
        }
        $images = [];
        if ($vehicle->path_name){
            foreach ($vehicle->path_name as $image){
                $images[] = getFile($vehicle->driver,$image);
            }
        }
        $category = CarCategory::where('status',1)->get();
        $brand = CarBrand::where('status',1)->get();

        return view('themes.light.user.sell_your_vehicle.edit',compact('vehicle','category','brand','images'));
    }

    public function update(Request $request,$id)
    {
        if( $request->images && $request->photos){
            $length = count($request->images) + count($request->photos);
        }elseif($request->photos){
            $length = count($request->photos);
        }elseif($request->images){
            $length = count($request->images);
        }else{
            return back()->with('warning',"Image Field is required");
        }
        $user =  Auth::user();
        $request->validate([
            'title' => 'required | string | max:100',
            'vehicle_type' => 'required | string | max:150',
            'engine_type' => 'required | string | max:150',
            'power' => 'required | string | max:150',
            'torque' => 'required | string | max:150',
            'displacement' => 'required | string | max:150',
            'transmission' => 'required | string | max:150',
            'testResult' => 'required | string | min:5 | max:500',
            'dimensions' => 'required | string | min:10 | max:500',
            'shortDescription' => 'required | string | min:10 | max:1000',
            'auction_ending_date' => 'required | date_format:Y-m-d',
            'description' => 'required | string | min:20 | max:2000',
            'brand_id' => 'required',
            'category_id' => 'required',
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:5000',new noOfMaxImg($length)],
           ]);
           $vehicle = Vehicle::with('details')->find($id);
            if ($vehicle->details->sold_status == 1){
                return abort(404);
            }elseif($request->price != $vehicle->details->price && $vehicle->biddingHistory){
                return back()->with('warning',"You Can Not Chage Price");
            }
            if($vehicle->user_id != Auth::user()->id){
                return abort(404);
            }
           $path = null;
         if ($request->photos){
             foreach($vehicle->path_name as $key => $image){
                 if(in_array($image,$request->photos)){
                     $path[] = $image;
                 }else{
                     $this->fileDelete($vehicle->driver,$image);
                 }
             }
         }else{
             if ($vehicle->path_name){
                 foreach($vehicle->path_name as $key => $image){

                     $this->fileDelete($vehicle->driver,$image);
                 }
             }
         }
           try{
                if($request->hasFile('images')){
                   $driver = null;
                   foreach( $request->images as $image){
                        $image = $this->fileUpload($image, config('filelocation.carImage.path'), null,null, 'avif',60);
                        if($image){
                            $path[] = $image['path'];
                            $driver = $image['driver'];
                        }else{
                            throw new Exception( 'Image could not be uploaded.',empty($image['path']));
                        }
                    }
                }
                $vehicle->path_name = $path;
                $vehicle->driver =  $driver ?? $vehicle->driver;
                $vehicle->user_id  = $user->id;
                $vehicle->category_id  = $request->category_id;
                $vehicle->brand_id = $request->brand_id;
                $vehicle->plan_id = $user->plan->id;
                $vehicle->save();
                $vehicle->details()->update([
                        'title' => $request->title,
                        'vehicle_type' => $request->vehicle_type,
                        'engine_type' => $request->engine_type,
                        'power' => $request->power,
                        'torque' => $request->torque,
                        'displacement' => $request->displacement,
                        'transmission' => $request->transmission,
                        'test_result' => $request->testResult,
                        'dimension' => $request->dimensions,
                        'short_description' => $request->shortDescription,
                        'description' => $request->description,
                        'price' => $request->price??$vehicle->details->price,
                        'auction_ending_date' => $request->auction_ending_date,
                ]);

                return back()->with('success','Your Vehicle  update succeefully');
           }catch(Exception $error){
            return back()->with('error', $error->getMessage());
           }

    }
    public  function destroy($id)
    {
        $vehicle = Vehicle::with('details','biddingHistory')->find($id);
        if($vehicle->details->sold_status == 1){
            if($vehicle->release_status == 0 || $vehicle->payment_status = 0){
                return back()->with('warning','You Can not Delete This Vehicle');
            }
        }
        if (!$vehicle->biddingHistory->first()){
            $vehicle->user->total_listed_car = $vehicle->user->total_listed_car - 1;
            $vehicle->user->update();
        }
        if($vehicle->user_id != Auth::user()->id){
            return abort(404);
        }
        foreach($vehicle->biddingHistory as $item){
            $item->delete();
        }
        $vehicle->details->delete();
        foreach ($vehicle->path_name as $path){
            $this->fileDelete($vehicle->driver,$path);
        }
        $vehicle->delete();
        return redirect()->route('auction')->with('success','Vehicle Delete Successfully');
    }

    public function releseProperty(Request $request)
    {
        $vehicle = Vehicle::where('release_status',0)->find($request->vehicle_id);
        if (Auth::user()->id == $vehicle->user_id){

            $vehicle->release_status = 1;
            $vehicle->update();
            $maxAmount = $vehicle->biddingHistory->max('bid_amount');
            $soldVehicle = BiddingHistory::where('vehicle_id', $vehicle->id)
                ->where('bid_amount', $maxAmount)
                ->first();
            $msg = [
                'username' => $soldVehicle->bidder->firstname." ".$soldVehicle->bidder->lastname,
                'vehicle_model' => $soldVehicle->vehicle->details->title,
                'release_date' => Carbon::now()->format('Y-m-d'),
                'seller_name' => $soldVehicle->vehicle->user->firstname." ".$soldVehicle->vehicle->user->lastname,
                'contact_number' => $soldVehicle->vehicle->user->phone,
                'address' => $soldVehicle->vehicle->user->address_one,
                'company_name' => basicControl()->site_title,
            ];

            $action = [
                "link" => '#',
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($soldVehicle->bidder, 'RELEASED_VEHICLE', $action);
            $this->userFirebasePushNotification($soldVehicle->bidder,'RELEASED_VEHICLE', "#");
            $this->sendMailSms($soldVehicle->bidder,'RELEASED_VEHICLE',$msg);
            return back()->with('success',"Successfully Released Your Property");
        }else{
            return back(404);
        }
    }
    public function vehicleBiddingHistory($id)
    {
        $vehicle = Vehicle::find($id);
        $historys = $vehicle->biddingHistory;
        $max_bid = BiddingHistory::where('vehicle_id',$vehicle->id)->where('bid_amount',$historys->max('bid_amount'))->first();

        $vehicleTitle = $vehicle->details->title;
        if ($max_bid != null){
            $report  = Report::where(function ($query)use($id,$max_bid){
                $query->where('repoter_id',Auth::user()->id)
                    ->where('reported_user_id',$max_bid->user_id)
                    ->where('vehicle_id',$id);
            })
                ->orWhere(function ($query)use($id,$max_bid){
                    $query->where('repoter_id',$max_bid->user_id)
                        ->where('reported_user_id',Auth::user()->id)
                        ->where('vehicle_id',$id);
                })->first();
        }else{
            $report = null;
        }

        return view(template().'vehicleBiddingHistory',compact('historys','vehicleTitle','report'));
    }
    public function deleteHistory(Request $request)
    {
        $bid = BiddingHistory::find($request->bid_id);
        $bid->delete();
        return back()->with('success',"Bid Delete Successfully");
    }

}
