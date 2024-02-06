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
        if($user->plan && $user->plan->expiry_date < now()->format('Y-m-d H:i:s')){
            return redirect()->route('plan')->with('warning','Please Upgrade Your Plan');
        }
        if(!$user->plan){
            return redirect()->route('plan')->with('warning','Please Purchase Plan and Sell Your Vehicle');
        }
        return $next($request);
    }
}
