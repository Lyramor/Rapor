<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPPKTRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $selectedRole = session('selected_role');

        // Daftar role yang dapat mengakses admin PPKT
        $adminPPKTRoles = [
            'Admin PPKPT Fakultas',
            'Admin PPKPT Prodi'
        ];

        // Cek apakah user memiliki role admin PPKT
        if (!in_array($selectedRole, $adminPPKTRoles)) {
            return redirect()->route('whistleblower.index')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin PPKPT.');
        }

        return $next($request);
    }
}