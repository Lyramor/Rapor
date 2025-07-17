<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminPPKT
{
    /**
     * Handle an incoming request.
     * Middleware ini untuk memastikan hanya Admin PPKPT yang bisa akses route admin
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $selectedRole = session('selected_role');
        $adminPPKTRoles = [
            'Admin PPKPT Fakultas',
            'Admin PPKPT Prodi'
        ];

        // Cek apakah user memiliki role admin PPKPT
        if (!in_array($selectedRole, $adminPPKTRoles)) {
            return redirect()->route('whistleblower.user.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin PPKPT.');
        }

        return $next($request);
    }
}