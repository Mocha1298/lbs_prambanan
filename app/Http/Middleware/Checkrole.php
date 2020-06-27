<?php

namespace App\Http\Middleware;

use Closure;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {
        if(in_array($request->user()->roles_id,$roles)){
            return $next($request);
        }
        else {
            return redirect('/');
        }
    }
}
