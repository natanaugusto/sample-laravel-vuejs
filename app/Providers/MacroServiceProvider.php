<?php

namespace App\Providers;

use App\Macros\WhereLike;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * Put the app macros here
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('whereLike', function($attrs, string $term) {
          return (new WhereLike($this))->search($attrs, $term);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
