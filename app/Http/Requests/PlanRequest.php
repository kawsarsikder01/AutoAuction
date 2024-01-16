<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use  Illuminate\Http\Request;

class PlanRequest 
{
   

    public function requestValidation($request,$id)
    {
        // $request->validate([
        //     'name' => 'required  | string | max:100',
        //     'price' => 'required | numeric',
        //     'title' => 'required | max:100',
        //     'services' =>'required'
        // ]);
        // if($request->price < 0 || $request->expiry_time){
        //     return redirect(route('admin.plan.edit',$id))->with('warning','the price and Expiry input must be an psitive number');
        // }
        // if($request->expiry_time && $request->unlimited_status){
        //     return redirect(route('admin.plan.edit',$id))->with('warning','you are selected expiry time and unlimited status');
        // }
        // if($request->expiry_time && $request->expiry_time_type == 'select'){
        //     $rules = [
        //         'expiry_time_type' => 'required',
        //     ];
        //     $customMessages = [
        //         'expiry_time_type.*.required' => 'The Expiry time type is required.',
        //     ];
        //    $validator = Validator::make([$request->expiry_time_type], $rules, $customMessages);
        //    if ($validator->fails()) {
        //         return redirect(route('admin.plan.edit',$id))->withErrors($validator)->withInput();
        //     }
        // }
        // if(!$request->expiry_time && !$request->unlimited_status){
        //     return redirect(route('admin.plan.edit',$id))->with('warning','you are not selected expire time or unlimited status');
        // }
        // return $request->all();
        
    }
}
