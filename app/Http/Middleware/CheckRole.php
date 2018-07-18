<?php
 
namespace App\Http\Middleware;
 
use Closure;
 
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role1, $role2)
    {
        if ((! $request->user()->hasRole($role1)) AND (! $request->user()->hasRole($role2)))
        {
            abort(401, 'Questa operazione non è consentita. I tuoi privilegi non sono sufficienti.');
        }
        return $next($request);
    }
}