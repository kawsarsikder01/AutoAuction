<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['service_name' => 'required']);
        Service::create([
            'service_name' => $request->service_name,
            'language_id'  => $request->language_id
        ]);
        return back()->with('success','Service Create Sucessfully');
    }
}
