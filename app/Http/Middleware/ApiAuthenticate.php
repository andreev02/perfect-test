<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if ($token == null) {
            return $this->sendError('Unathorized', 401);
        }

        if ($token !== config('services.api.token')) {
            return $this->sendError('Unathorized', 401);
        }
        
        return $next($request);
    }
}
