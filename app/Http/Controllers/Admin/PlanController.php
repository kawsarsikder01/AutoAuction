<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Language;
use App\Http\Requests\PlanRequest;

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
        Plan::create([
            'plan_name' => $request->plan_name,
            'price' => $request->price,
            'currency'=> basicControl()->base_currency,
            'currency_symbol'=> basicControl()->currency_symbol,
            'number_of_listing' => $request->number_of_listing,
            'number_of_images' => $request->number_of_images,
            'title' => $request->title,
            'access_auction' =>$request->access_auction,
            'customer_support' =>$request->customer_support,
            'promoted_listing' =>$request->promoted_listing,
            'top_search_result' =>$request->top_search_result,
            'share_other_platform' =>$request->share_other_platform,
            'expiry_time' => $request->expiry_time,
            'expiry_time_type' => $request->expiry_time_type ,
            'status' => $request->status,
            'language_id' => $request->language_id
        ]);
        return redirect(route('admin.plan.list'))->with('success','Plan Create Successfully');
        
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
        $plan = Plan::findOrFail($id);
        $language = Language::findOrFail($language);
        $defaultLanguage = Language::where('default_status', true)->first();
        return view('admin.plan.edit',compact('plan','defaultLanguage','language'));
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
        'customer_support' =>$request->customer_support,
        'promoted_listing' =>$request->promoted_listing,
        'top_search_result' =>$request->top_search_result,
        'share_other_platform' =>$request->share_other_platform,
        'expiry_time' => $request->expiry_time,
        'expiry_time_type' => $request->expiry_time_type ,
        'status' => $request->status,
        'language_id' => $request->language_id
       ]);
        return redirect(route('admin.plan.list'))->with('success','Plan update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return back()->with('success', 'Plan Delete Successfully');
    }
}
