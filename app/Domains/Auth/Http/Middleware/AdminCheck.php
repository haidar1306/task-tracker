<?php

namespace App\Domains\Auth\Http\Middleware;

use App\Domains\Auth\Models\User;
use Closure;

/**
 * Class AdminCheck.
 */
class AdminCheck
{
    /**
     * @param $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Log::info('Dubai Admin Check', [
            'user_id' => optional($request->user())->id,
            'user_type' => optional($request->user())->type,
            'is_admin' => $request->user()
                ? $request->user()->isType(User::TYPE_ADMIN)
                : false,
            'url' => $request->fullUrl(),
        ]);
        if ($request->user() && $request->user()->isType(User::TYPE_ADMIN)) {
            return $next($request);
        }

        return redirect()->route('frontend.index')
            ->withFlashDanger('ADMIN CHECK BLOCKED');
    }
}
