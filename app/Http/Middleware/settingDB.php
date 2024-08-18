<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class settingDB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->can('setting db')){
            return $next($request);
        }else{
            return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
        }
    }
}
