<?php

namespace App\Http\Middleware;

use Closure;
use URL;
use Languages;

class CheckLanguageCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();


        foreach (Languages::getCollection() as $language) {
            if ($path === $language->code) {
                return $next($request);
            }

            if (strpos($path, $language->code . '/') === 0) {
                return $next($request);
            }
        }

        return redirect()->to(Languages::default()->code . '/' . $path);
    }
}
