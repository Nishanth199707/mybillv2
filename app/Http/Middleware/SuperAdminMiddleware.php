<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // dd(auth()->user(), $request->all());
        Log::info('Middleware accessed', ['user' => auth()->user(), 'request_data' => $request->all()]);
    
        if (!auth()->check() || auth()->user()->usertype !== 'superadmin') {
            return redirect()->route('sadamin.login')->with('error', 'Unauthorized access!');
        }

        return $next($request);
    }
}
