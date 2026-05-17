<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('x-api-key');

        if ($apiKey !== env('API_KEY')) {

            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }
}
