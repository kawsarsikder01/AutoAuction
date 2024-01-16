<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if($user->plan && $user->plan_expire_date < Carbon::now()){
            if ($user->total_listed_car > 0){
                $user->total_listed_car = 0;
                $user->update();
            }
            return redirect()->route('plan')->with('warning','Please Upgrade Your Plan');
        }
        if(!$user->plan){
            return redirect()->route('plan')->with('warning','Please Purchase Plan and Sell Your Vehicle');
        }

        return $next($request);
    }
}
