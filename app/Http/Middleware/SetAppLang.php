<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
class SetAppLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
           // url = domain/en/post
           $localeSegment = $request->segment(2);

           // Check if the segment is a valid locale
           if (in_array($localeSegment, config('app.available_locales'))) {
               App::setLocale($localeSegment);
       
               // Remove the locale segment from the URL so it doesn't affect subsequent route matching
               $request->route()->forgetParameter('locale');
       
               return $next($request);
           }
       
           abort(400);
    }
}
