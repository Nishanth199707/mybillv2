<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        $userId = Auth::user()->id;
        $auth_user =  Auth::user();
        $gstavailable =  Business::where('user_id','=',$userId)->select('gstavailable')->first();
        // dd($gstavailable);
        if (Auth::check() && $auth_user->usertype == $userType) {
            $userId = Auth::user()->id;
            $request->session()->put('user_id', $userId);
            $request->session()->put('gstavailable', ((isset($gstavailable) && !empty($gstavailable)) ? $gstavailable->gstavailable:'no'));

            return $next($request);
        }else{
            return redirect()->route('login');


        }

        return response()->json(['error' => 'You do not have permission to access this page.'], 403);
    }
}
