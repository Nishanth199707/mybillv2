<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\SubUser;
use App\Models\User;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        $auth_user = Auth::user();

        // Check if the authenticated user is a main user and has the correct usertype
        if ($auth_user instanceof User && $auth_user->usertype == 'superadmin') {
            // User is authorized, proceed with setting session and continuing request
            return $this->setSessionAndProceed($request, $auth_user, $next);
        }

        // If not a main user, check for sub-user session
        if (session('sub_user_id')) {
            // Retrieve sub-user from session
            $subUser = SubUser::find(session('sub_user_id'));

            if ($subUser && $subUser->usertype === $userType) {
                // Set session data for the sub-user
                return $this->setSessionAndProceed($request, $subUser, $next);
            }
        }

        // If neither the main user nor the sub-user is authorized, redirect to login page
        return redirect()->route('login')
            ->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Set the session data for the authenticated user and proceed with the request.
     *
     * @param Request $request
     * @param User|SubUser $auth_user
     * @param Closure $next
     * @return Response
     */
    protected function setSessionAndProceed(Request $request, $auth_user, Closure $next): Response
    {
        $userId = $auth_user->id;

        // Fetch GST availability for both main users and sub-users
        $gstavailable = Business::where('user_id', $userId)->select('gstavailable')->first();

        // Store session data
        $request->session()->put('user_id', $userId);
        $request->session()->put('gstavailable', $gstavailable->gstavailable ?? 'no');

        // Optionally, if sub-user authentication is required, we can do that
        // but we'll assume here that sub-users are just associated with the user session.

        // Continue with the request
        return $next($request);
    }
}
