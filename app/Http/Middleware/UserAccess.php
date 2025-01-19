<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Business;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): mixed
    {
        if (!Auth::check()) {
            // Redirect unauthenticated users to login
            return redirect()->route('login');
        }

        $auth_user = Auth::user();
        $userId = $auth_user->id;

        $userType = $auth_user->usertype;
        // Ensure the user's type matches the required type
        if ($auth_user->usertype !== $userType) {
            return response()->json(['error' => 'You do not have permission to access this page.'], 403);
        }

        // Fetch GST availability from the Business model
        $gstavailable = Business::where('user_id', $userId)->value('gstavailable') ?? 'no';

        // Handle staff-specific logic
        if ($auth_user->usertype === 'staff') {
            $request->session()->put('user_id', $auth_user->parent_id);
            $request->session()->put('sub_user', $userId);
            $request->session()->put('user_type', 'staff');
            $request->session()->put('gstavailable', $gstavailable);

            return $next($request);
        }

        // Handle superadmin-specific logic
        if ($auth_user->usertype === 'superadmin') {
            $request->session()->put('user_id', $userId);
            $request->session()->put('user_type', 'admin');
            $request->session()->put('gstavailable', $gstavailable);

            return $next($request);
        }

        // Redirect to login if no conditions match
        return redirect()->route('login');
    }
}
