<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowed = ['super_admin', 'school_admin', 'teacher', 'secretary', 'auditor'];
        if (! in_array($request->user()->user_type, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
