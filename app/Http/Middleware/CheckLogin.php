<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('is_login')) {
            return redirect('/login');
        }

        $timeout = 10 * 60; // 10 menit

        // Cek last activity
        if (Session::has('last_activity')) {

            $inactiveTime = time() - Session::get('last_activity');

            if ($inactiveTime > $timeout) {

                Session::flush();

                return redirect('/login')
                    ->with('error', 'Session habis');
            }
        }

        Session::put('last_activity', time());

        return $next($request);
    }
}
