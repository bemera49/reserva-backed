<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleApiErrors
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $response = $next($request);
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
