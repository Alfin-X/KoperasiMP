<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        if (!empty($roles) && !$user->hasAnyRole($roles)) {
            \Log::info('Role check failed', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role_id' => $user->role_id,
                'user_role_name' => $user->role ? $user->role->name : 'No role',
                'required_roles' => $roles,
                'hasAnyRole_result' => $user->hasAnyRole($roles)
            ]);
            abort(403, 'Anda tidak memiliki akses ke halaman ini. (User: ' . $user->email . ', Role: ' . ($user->role ? $user->role->name : 'No role') . ', Required: ' . implode(',', $roles) . ')');
        }

        return $next($request);
    }
}
