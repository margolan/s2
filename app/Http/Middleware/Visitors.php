<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Visitors
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response)
    {

        if(Auth::check() && Auth::user()->role === 'admin') return;

        if (
            $request->expectsJson() ||
            $request->is('build/*') ||
            $request->is('favicon.ico') ||
            $response->getStatusCode() === 404
        ) {
            return;
        }

        $visitor = [
            'ip'         => $request->ip(),
            'user'       => Auth::user()->name ?? 'NR',
            'userAgent'    => $request->userAgent(),
            'url' => $request->path(),
        ];

        Visitor::create($visitor);
    }
}
