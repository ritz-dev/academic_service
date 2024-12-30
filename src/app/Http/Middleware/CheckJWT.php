<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        
        $client = new Client();
        
        logger($userManagementServiceUrl);

        $response = $client->get($userManagementServiceUrl, [
            'headers' => [
                'Authorization' => $token, 
                ] 
            ]);
        logger($response);
        // try {
            
        // } catch (\Exception $e) { 
        //     return response()->json(['error' => 'Service unavailable'], 503); 
        // } 
        //     if ($response->getStatusCode() !== 200) {
        //         return response()->json(['error' => 'Unauthorized'], 401); 
        // }
            // $request->merge(['user' => json_decode($response->getBody()->getContents())]);

        return $next($request);
    }
}
