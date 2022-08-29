<?php

namespace App\Http\Middleware;

use App\Models\UserPermissions;
use Closure;
use Illuminate\Http\Request;
use League\Flysystem\Config;

class PermissionControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       $prefix = str_replace('/','',\request()->route()->getPrefix());
       $index = array_search($prefix,\Illuminate\Support\Facades\Config::get('app.permissions'));
       if (!UserPermissions::getMyControl($index)){return redirect('/');}
        return $next($request);
    }
}
