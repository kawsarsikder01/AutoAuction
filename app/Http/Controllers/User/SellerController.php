<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Report;
use App\Models\Visitor;
use App\Traits\Notify;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Models\CarCategory;
use App\Models\CarBrand;
use App\Traits\Upload;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use App\Rules\noOfMaxImg;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class SellerController extends Controller
{
    use Upload;
    use Notify;

    public function index()
    {
        $category = CarCategory::where('status', 1)->get();
        $brand = CarBrand::where('status', 1)->get();
        return view('themes.light.user.sell_your_vehicle.create', compact('category', 'brand'));
    }

    public function maximumListingValidation()
    {
        $user = Auth::user();
        $maximumListing = $user->plan->noOfListing;
        $totalListed = $user->total_listed_car;
        if ($maximumListing > $totalListed) {
            return true;
        } else {
            return false;
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $maximumListing = $user->plan->noOfListing;
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
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5000', new noOfMaxImg($request->images ? count($request->images) : 0)],
        ]);

        if (!$this->maximumListingValidation()) {
            return back()->with('warning', "You Can not post more than $maximumListing Vehicle");
        }


        $path = null;
        try {
            if ($request->file('images')) {
                $driver = array();
                $path = array();
                foreach ($request->images as $image) {
                    $image = $this->fileUpload($image, config('filelocation.carImage.path'), null, null, 'avif', 60);
                    if ($image) {
                        $path[] = $image['path'];
                        $driver = $image['driver'];
                    } else {
                        throw new Exception('Image could not be uploaded.', empty($image['path']));
                    }
                }
            }
            $vehicle = new Vehicle();
            $vehicle->path_name = $path;
            $vehicle->driver = $driver ?? null;
            $vehicle->user_id = $user->id;
            $vehicle->category_id = $request->category_id;
            $vehicle->brand_id = $request->brand_id;
            $vehicle->user_current_plan_id = $user->plan->id;
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

            return back()->with('success', 'Your Vehicle  add succeefully');
        } catch (Exception $error) {
            return back()->with('error', $error->getMessage());
        }
    }

    public function listedVehicle()
    {

        $user = Auth::user();
        if (!$user->plan) {
            abort(403);
        }
        $vehicles = Vehicle::with('details')
                    ->whereHas('details',function($query){
                        $query->select('id', 'title', 'price', 'sold_price', 'sold_status');
                    })
                    ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(basicControl()->paginate);
        $data['categories'] = CarCategory::get();
        $data['brands'] = CarBrand::get();
        return view(template() . 'user.pages.listedVehicle', compact('vehicles'), $data);
    }

    public function edit($id)
    {
        try {
            $vehicle = Vehicle::with('details')->findOrFail($id);
        if ($vehicle->user_id != Auth::user()->id) {
            abort(403);
        }
        $images = [];
        if ($vehicle->path_name) {
            foreach ($vehicle->path_name as $image) {
                $images[] = getFile($vehicle->driver, $image);
            }
        }
        $category = CarCategory::where('status', 1)->get();
        $brand = CarBrand::where('status', 1)->get();

        return view('themes.light.user.sell_your_vehicle.edit', compact('vehicle', 'category', 'brand', 'images'));
        } catch (Exception $error ) {
            abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->images && $request->photos) {
            $length = count($request->images) + count($request->photos);
        } elseif ($request->photos) {
            $length = count($request->photos);
        } elseif ($request->images) {
            $length = count($request->images);
        } else {
            return back()->with('warning', "Image Field is required");
        }
        $user = Auth::user();
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
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:5000', new noOfMaxImg($length)],
        ]);

        try {

            $vehicle = Vehicle::with('details')->findOrFail($id);
            if ($vehicle->details->sold_status == 1) {
                abort(403);
            } elseif ($request->price != $vehicle->details->price && $vehicle->biddingHistory) {
                return back()->with('warning', "You Can Not Chage Price");
            }
            if ($vehicle->user_id != Auth::user()->id) {
                abort(403);
            }
            $path = null;
            if ($request->photos) {
                foreach ($vehicle->path_name as $key => $image) {
                    if (in_array($image, $request->photos)) {
                        $path[] = $image;
                    } else {
                        $this->fileDelete($vehicle->driver, $image);
                    }
                }
            } else {
                if ($vehicle->path_name) {
                    foreach ($vehicle->path_name as $key => $image) {

                        $this->fileDelete($vehicle->driver, $image);
                    }
                }
            }
            if ($request->hasFile('images')) {
                $driver = null;
                foreach ($request->images as $image) {
                    $image = $this->fileUpload($image, config('filelocation.carImage.path'), null, null, 'avif', 60);
                    if ($image) {
                        $path[] = $image['path'];
                        $driver = $image['driver'];
                    } else {
                        throw new Exception('Image could not be uploaded.', empty($image['path']));
                    }
                }
            }
            $vehicle->path_name = $path;
            $vehicle->driver = $driver ?? $vehicle->driver;
            $vehicle->user_id = $user->id;
            $vehicle->category_id = $request->category_id;
            $vehicle->brand_id = $request->brand_id;
            $vehicle->user_current_plan_id = $vehicle->user_current_plan_id;
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
                'price' => $request->price ?? $vehicle->details->price,
                'auction_ending_date' => $request->auction_ending_date,
            ]);

            return back()->with('success', 'Your Vehicle  update succeefully');
        } catch (Exception $error) {
            return back()->with('error', $error->getMessage());
        }

    }

    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::with('details', 'biddingHistory')->findOrFail($id);
        if ($vehicle->details->sold_status == 1) {
            if ($vehicle->release_status == 0 || $vehicle->payment_status = 0) {
                return back()->with('warning', 'You Can not Delete This Vehicle');
            }
        }
        if ($vehicle->user_id != Auth::user()->id) {
           abort(403);
        }
        if (!$vehicle->biddingHistory->first()) {
            $vehicle->user->total_listed_car = $vehicle->user->total_listed_car - 1;
            $vehicle->user->update();
        }
        $vehicle->biddingHistory()->delete();
        $vehicle->reacts()->delete();
        $vehicle->details->delete();
        foreach ($vehicle->path_name as $path) {
            $this->fileDelete($vehicle->driver, $path);
        }
            $vehicle->reports()->delete();
        $vehicle->delete();
        return redirect()->route('auction')->with('success', 'Vehicle Delete Successfully');
        } catch (Exception $error) {
            return back()->with('error',$error->getMessage());
        }
    }

    public function releaseProperty(Request $request)
    {

        try {
            $vehicle = Vehicle::where('release_status', 0)->findOrFail($request->vehicle_id);
            if (Auth::user()->id != $vehicle->user_id) {
                throw new Exception('You Can Not Release This Vehicle');
            }
            $vehicle->release_status = 1;
            $vehicle->update();
            $maxAmount = $vehicle->biddingHistory->max('bid_amount');
            $soldVehicle = BiddingHistory::where('vehicle_id', $vehicle->id)
                ->where('bid_amount', $maxAmount)
                ->first();
            $msg = [
                'username' => $soldVehicle->bidder->firstname . " " . $soldVehicle->bidder->lastname,
                'vehicle_model' => $soldVehicle->vehicle->details->title,
                'release_date' => Carbon::now()->format('Y-m-d'),
                'seller_name' => $soldVehicle->vehicle->user->firstname . " " . $soldVehicle->vehicle->user->lastname,
                'contact_number' => $soldVehicle->vehicle->user->phone,
                'address' => $soldVehicle->vehicle->user->address_one,
                'company_name' => basicControl()->site_title,
            ];

            $action = [
                "link" => route('user.listed.vehicle'),
                "icon" => "fas fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($soldVehicle->bidder, 'RELEASED_VEHICLE',$msg, $action);
            $this->userFirebasePushNotification($soldVehicle->bidder, 'RELEASED_VEHICLE',$msg,  route('user.listed.vehicle'));
            $this->sendMailSms($soldVehicle->bidder, 'RELEASED_VEHICLE',$msg);
            return back()->with('success', "Successfully Released Your Property");
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function vehicleBiddingHistory($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            if ($vehicle->user_id != Auth::user()->id){
                throw new Exception('Vehicle Not Found');
            }
            $historys = BiddingHistory::where('vehicle_id', $vehicle->id)->orderByDesc('created_at')->paginate(basicControl()->paginate);
            $max_bid = BiddingHistory::where('vehicle_id', $vehicle->id)->where('bid_amount', $historys->max('bid_amount'))->first();

            $vehicleTitle = $vehicle->details->title;
            if ($max_bid != null) {
                $report = Report::where(function ($query) use ($id, $max_bid) {
                    $query->where('repoter_id', Auth::user()->id)
                        ->where('reported_user_id', $max_bid->user_id)
                        ->where('vehicle_id', $id);
                })
                    ->orWhere(function ($query) use ($id, $max_bid) {
                        $query->where('repoter_id', $max_bid->user_id)
                            ->where('reported_user_id', Auth::user()->id)
                            ->where('vehicle_id', $id);
                    })
                    ->first();
            } else {
                $report = null;
            }
            return view(template() . 'user.pages.vehicleBiddingHistory', compact('historys', 'vehicleTitle', 'report'));
        }catch (\Exception $exception){
            dd($exception->getMessage());
            abort(404);
        }
    }
    public function monthList()
    {
        $currentYear = Carbon::now()->year;
        $monthsByYear = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthsByYear[Carbon::create($currentYear, $month)->format('F')] = '00';
        }

        return $monthsByYear;
    }

    public function dayList()
    {
        $totalDays = Carbon::now()->endOfMonth()->format('d');
        $daysByMonth = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            array_push($daysByMonth, ['Day ' . sprintf("%02d", $i) => 0]);
        }

        return collect($daysByMonth)->collapse();
    }

    public function auctionStatistic($auction_id)
    {
        $topbidders =  BiddingHistory::where('vehicle_id',$auction_id)->orderByDesc('bid_amount')->take(4)->get();
        return view(template().'user.pages.statistic',compact('auction_id','topbidders'));
    }

    public function auctionVisitors($auction_id)
    {
        $currentMonthVisitors = $this->dayList();
        $labels = $this->dayList();
        $monthlyVisitor = Visitor::whereMonth('created_at', Carbon::now()->month)
            ->where('auction_id', $auction_id)
            ->select(
                DB::raw('COUNT(id) as perDayVisitor'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
        foreach ($monthlyVisitor as $item){
            $currentMonthVisitors[$item['date']] =  $item['perDayVisitor'];
        }
        $lastMonthVisitors = $this->dayList();
        $lastMonth = Visitor::whereMonth('created_at',Carbon::now()->subMonth())
            ->where('auction_id', $auction_id)
            ->select(
                DB::raw('COUNT(id) as perDayVisitor'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
        foreach ($lastMonth as $item){
            $lastMonthVisitors[$item['date']] =  $item['perDayVisitor'];
        }

        return response()->json([
            'currentMonthVisitors' => $currentMonthVisitors->values(),
            'lastMonthVisitors' => $lastMonthVisitors->values(),
            'labels' => $labels->keys()
        ]);
    }

    public function getVisitorsHistory($auction_id)
    {
        $userLoginsData = DB::table('visitors')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->select('browser_info', 'os', 'device')
            ->where('auction_id', $auction_id)
            ->get();

        $data['visitorsBrowserData'] = $userLoginsData->groupBy('browser_info')->map->count();
        $data['visitorsOSData'] = $userLoginsData->groupBy('os')->map->count();
        $data['visitorsDeviceData'] = $userLoginsData->groupBy('device')->map->count();
        return response()->json([
            'visitorsBrowserData'  => $data['visitorsBrowserData'],
            'visitorsOSData' => $data['visitorsOSData'],
            'visitorsDeviceData' =>  $data['visitorsDeviceData']
        ]);
    }

}

