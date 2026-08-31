<?php

namespace App\Domains\Auth\Http\Middleware;

use Closure;

/**
 * Class SuperAdminCheck.
 */
class SuperAdminCheck
{
    /**
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->hasAllAccess()) {
            return $next($request);
        }

       return redirect()->route('frontend.index')
    ->withFlashDanger('SUPER ADMIN CHECK BLOCKED');
    }
}
