<?php

namespace App\Http\Controllers;

use App\Models\React;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReactController extends Controller
{
    public function getReact(Request $request,$id)
    {

        $ipAddress = $request->header('X-Forwarded-For') ?? $request->ip(); // Replace with the IP address you want to check
        $react = new React();
        $react->vehicle_id = $id;
        $react->ip_address = $ipAddress;
        $react->save();
        return back();

    }
    public function unsubmit($id){
        $react = React::where('vehicle_id',$id)->where('ip_address',request()->ip())->first();
        if($react){
            $react->delete();
            return back();
        }else{
            return back()->with('error','Can not find react');
        }
    }
}
