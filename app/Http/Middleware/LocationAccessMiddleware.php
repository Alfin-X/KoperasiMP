<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationAccessMiddleware
{
    /**
     * Handle an incoming request.
     * This middleware ensures that Pelatih can only access data from their assigned location.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Only apply location restriction to Pelatih role
        if ($user->hasRole('pelatih')) {
            // Check if user has a location assigned
            if (!$user->location_id) {
                abort(403, 'Anda belum memiliki lokasi yang ditugaskan. Hubungi administrator.');
            }

            // For route model binding, check if the model has location_id
            $routeParameters = $request->route()->parameters();
            
            foreach ($routeParameters as $parameter) {
                if (is_object($parameter)) {
                    // Check if the model has location_id property
                    if (property_exists($parameter, 'location_id')) {
                        if ($parameter->location_id !== $user->location_id) {
                            abort(403, 'Anda tidak memiliki akses untuk data dari lokasi ini.');
                        }
                    }
                    
                    // Special handling for Member model (check through user relationship)
                    if (get_class($parameter) === 'App\Models\Member') {
                        if ($parameter->user && $parameter->user->location_id !== $user->location_id) {
                            abort(403, 'Anda tidak memiliki akses untuk data anggota dari lokasi lain.');
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
