<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanPurchaseHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Language;
use App\Http\Requests\PlanRequest;
use Yajra\DataTables\DataTables;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        $languages = Language::get();
        $plans = Plan::where('language_id',  $defaultLanguage->id)->get();

        return view('admin.plan.index',compact('plans','languages','defaultLanguage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $defaultLanguage = Language::where('default_status', true)->first();
        return view('admin.plan.create',compact('defaultLanguage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_name'         => 'required | string | max:100',
            'price'             => 'required | numeric',
            'title'             => 'required | max:100 | string',
            'number_of_listing' => 'required | numeric',
            'number_of_images'  => 'required | numeric',
            'expiry_time'       => 'required |numeric',
            'expiry_time_type'  => 'required | string'
        ]);
        if($request->price < 0 || $request->expiry_time < 0){
            return back()->with('warning','the price and Expiry input must be an psitive number');
        }
       try {
        Plan::create([
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'currency'=> basicControl()->base_currency,
            'currency_symbol'=> basicControl()->currency_symbol,
            'number_of_listing' => $request->number_of_listing,
            'number_of_images' => $request->number_of_images,
            'title' => $request->title,
            'access_auction' =>$request->access_auction,
            'promoted_listing' =>$request->promoted_listing,
            'share_other_platform' =>$request->share_other_platform,
            'expiry_time' => $request->expiry_time,
            'expiry_time_type' => $request->expiry_time_type ,
            'status' => $request->status,
            'language_id' => $request->language_id
        ]);
        return redirect(route('admin.plan.list'))->with('success','Plan Create Successfully');
       } catch (\Exception $exception) {
        return back()->with('error',$exception->getMessage());
       }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id , $language = NULL)
    {
        try {
            $plan = Plan::findOrFail($id);
            $language = Language::findOrFail($language);
            $defaultLanguage = Language::where('default_status', true)->first();
            return view('admin.plan.edit',compact('plan','defaultLanguage','language'));
        }catch (\Exception $exception){
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {

        $request->validate([
            'plan_name'         => 'required | string | max:100',
            'price'             => 'required | numeric',
            'title'             => 'required | max:100 | string',
            'number_of_listing' => 'required | numeric',
            'number_of_images'  => 'required | numeric',
            'expiry_time'       => 'required |numeric',
            'expiry_time_type'  => 'required | string'
        ]);
        if($request->price < 0 || $request->expiry_time < 0){
            return back()->with('warning','the price and Expiry input must be an psitive number');
        }
        try {
            $plan = Plan::findOrFail($id);
            $plan->update([
                'plan_name' => $request->plan_name,
                'price' => $request->price,
                'currency'=> basicControl()->base_currency,
                'currency_symbol'=> basicControl()->currency_symbol,
                'number_of_listing' => $request->number_of_listing,
                'number_of_images' => $request->number_of_images,
                'title' => $request->title,
                'access_auction' =>$request->access_auction,
                'promoted_listing' =>$request->promoted_listing,
                'share_other_platform' =>$request->share_other_platform,
                'expiry_time' => $request->expiry_time,
                'expiry_time_type' => $request->expiry_time_type ,
                'status' => $request->status,
                'language_id' => $request->language_id
            ]);
            return redirect(route('admin.plan.list'))->with('success','Plan update Successfully');
        }catch (\Exception $exception){
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $plan = Plan::findOrFail($id);
            $plan->delete();
            return back()->with('success', 'Plan Delete Successfully');
        }catch (\Exception $exception){
            abort(404);
        }
    }
    public  function purchaseHistory()
    {
        return  view('admin.plan.planPurchaseHistory');
    }
    public function getPurchaseHistory()
    {
        $purchaseHistorys = PlanPurchaseHistory::query();

        return DataTables::of($purchaseHistorys)
            ->addColumn('user',function ($item){
                $user = User::findOrFail($item->user_id);
                return '<a class="d-flex align-items-center me-2" href="'.route('admin.user.view.profile',$item->user_id ).'">
                <div class="flex-shrink-0">
                    '.$user->profilePicture().'
                </div>
                <div class="flex-grow-1 ms-3">
                  <h5 class="text-hover-primary mb-0">' . $user->firstname . ' ' . $user->lastname . '</h5>
                  <span class="fs-6 text-body">@' . $user->username ?? 'Unknown' . '</span>
                </div>
              </a>';
            })
            ->addColumn('plan_name',function ($item){
               return $item->plan_name;
            })
            ->addColumn('price',function ($item){
                return currencyPosition($item->price);
            })
            ->addColumn('trx_id',function ($item){
                return $item->trx_id;
            })
            ->addColumn('payment_method',function ($item){
                return $item->payment_method;
            })
            ->addColumn('purchase_date',function ($item){
                return dateTime($item->purchase_date);
            })
            ->addColumn('expire_date',function ($item){
                return dateTime($item->expiry_date);
            })
            ->addColumn('validity',function ($item){
                if ($item->expiry_date<Carbon::now() || $item->status == 0){
                    $firstSpan = "badge bg-soft-danger text-danger";
                    $secoundSpan = "bg-danger";
                }else{
                    $firstSpan = "badge bg-soft-success text-success";
                    $secoundSpan = "bg-success";
                }
                if ($item->expiry_date<Carbon::now()){
                    $text = "Expired";
                }elseif($item->status == 0){
                    $text = "Inactive";
                }else{
                    $text = "Active";
                }
                return
                    " <span  class='$firstSpan' >
                        <span class='legend-indicator $secoundSpan'>
                        </span>
                        $text
                     </span>";
            })
            ->rawColumns(['user','plan_name,','price','trx_id','payment_method','purchase_date','expire_date','validity'])
            ->make(true);
    }
}

