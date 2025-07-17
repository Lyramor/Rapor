<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\RoleHelper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class WhistleblowerRedirect
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

        $selectedRole = session('selected_role');
        
        // Debug: Log informasi role
        Log::info('WhistleblowerRedirect Middleware');
        Log::info('Current Role: ' . $selectedRole);
        Log::info('All User Roles: ' . json_encode(RoleHelper::getAllUserRoles()));
        
        // Gunakan helper untuk cek role
        $isAdminPPKT = RoleHelper::isAdminPPKT($selectedRole);
        
        Log::info('Is Admin PPKPT: ' . ($isAdminPPKT ? 'Yes' : 'No'));

        // Jika role adalah Admin PPKT, redirect ke dashboard admin
        if ($isAdminPPKT) {
            Log::info('Redirecting to admin dashboard');
            return redirect()->route('admin.whistleblower.dashboard');
        } else {
            // Selain role Admin PPKT, redirect ke dashboard user
            Log::info('Redirecting to user dashboard');
            return redirect()->route('whistleblower.user.dashboard');
        }
    }
}