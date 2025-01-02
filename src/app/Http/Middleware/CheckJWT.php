<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $userManagementServiceUrl = config('services.user_management.url') . '/validate-token';
    
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => $token, // Pass the actual token from the request
            ])->get($userManagementServiceUrl);

            logger($response);

            if ($response->failed()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // // Decode response and convert to array for merging
            // $user = $response->json();

            // // Ensure `user` data is merged into the request
            // $request->merge(['user' => $user]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Service unavailable', 'details' => $e->getMessage()], 503);
        }

        return $next($request);
    }
}
