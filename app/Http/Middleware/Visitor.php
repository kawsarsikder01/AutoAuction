<?php

namespace App\Http\Middleware;

use App\Helpers\UserSystemInfo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor as VisitorModel;
use Illuminate\Support\Facades\Cache;

class Visitor
{



    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $urlSegments = explode('/', $request->url());
        $auctionId = end($urlSegments);
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        $key = "bouncing_time_{$auctionId}_{$ipAddress}_{$userAgent}";

        if (!Cache::has($key)) {
            $bouncingTime = now();

            // Log the bouncing time, IP address, and browser info to the database
            VisitorModel::create([
                'auction_id' => $auctionId,
                'ip_address' => $ipAddress,
                'bouncing_time' => $bouncingTime,
                'browser_info'=>UserSystemInfo::get_browsers(),
                'os'=>UserSystemInfo::get_os(),
                'device'=>UserSystemInfo::get_device(),
                'user_agent' => $userAgent,
            ]);



            // Cache the bouncing time for future reference
            Cache::put($key, $bouncingTime, now()->addMinutes(30));
        }
        return $next($request);
    }
}
