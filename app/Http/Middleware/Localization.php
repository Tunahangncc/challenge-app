<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check header request and determine localization
        $local = ($request->hasHeader('X-Localization')) ? $request->header('X-Localization') : 'en';

        // set laravel localization
        app()->setLocale($local);

        // continue request
        return $next($request);
    }
}
