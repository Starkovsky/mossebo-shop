<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('trim', function($attribute, $value) {
            return empty($value) ? true : trim($value);
        });

        \Validator::extend('phone', function($attribute, $value) {
            $plusPos = strpos($value, '+');
            $value = preg_replace('/[\(\)\-\+\s]/i', '', $value);

            if (! ctype_digit($value)) {
                return false;
            }

            return $plusPos === 0 ? '+' . $value : $value;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
