<?php

namespace App\Http\Controllers;

use App\Models\React;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReactController extends Controller
{
    public function submit(Request $request,$id)
    {
        $ipAddress = $request->header('X-Forwarded-For') ?? $request->ip(); // Replace with the IP address you want to check
        $react = new React();
        $react->vehicle_id = $id;
        $react->ip_address = $ipAddress;
        $react->save();
        return response()->json('success');

    }
    public function unsubmit($id){
        $react = React::where('vehicle_id',$id)->where('ip_address',request()->ip())->first();
        if($react){
            $react->delete();
            return response()->json('success');
        }else{
            return response()->json('Can not find react');
        }
    }
    public function getReact($id)
    {
        $react = React::where('vehicle_id',$id)->get();
        return response()->json($react);
    }
}
