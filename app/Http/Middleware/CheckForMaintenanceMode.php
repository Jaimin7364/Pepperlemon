<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. If maintenance mode is off, proceed normally
        if (!config('maintenance.enabled', false)) {
            return $next($request);
        }

        // 2. Allow framework health check
        if ($request->is('up')) {
            return $next($request);
        }

        // 3. Secret bypass in URL (?bypass=secret_key)
        $bypassSecret = config('maintenance.bypass_secret');
        if (!empty($bypassSecret) && $request->query('bypass') === $bypassSecret) {
            if ($request->hasSession()) {
                $request->session()->put('maintenance_bypass', true);
            }
            return redirect($request->url());
        }

        // 4. If session already has bypass permission
        if ($request->hasSession() && $request->session()->get('maintenance_bypass') === true) {
            return $next($request);
        }

        // 5. Allowed IP addresses
        $allowedIps = config('maintenance.allowed_ips', []);
        if (in_array($request->ip(), $allowedIps, true)) {
            return $next($request);
        }

        // 6. Return 503 Maintenance Page
        return response()->view('errors.503', [
            'title' => config('maintenance.title', 'Under Maintenance'),
            'message' => config('maintenance.message', 'Pepperlemon is currently undergoing scheduled maintenance. We will be back online shortly!'),
            'estimated_time' => config('maintenance.estimated_time', 'A few minutes'),
        ], 503);
    }
}
