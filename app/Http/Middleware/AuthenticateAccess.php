<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class AuthenticateAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedSecrets = explode(',', env('ALLOWED_SECRETS'));
        if (in_array($request->header('Authorization'), $allowedSecrets)) {
            return $next($request);
        }
        abort(Response::HTTP_UNAUTHORIZED);
    }
}
