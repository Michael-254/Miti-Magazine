<?php

/**
 * @Author: Evans Wanguba
 * @Date:   2020-01-10 14:02:33
 * @Last Modified by:   Evans Wanguba
 * @Last Modified time: 2016-02-16 17:15:18
 */

namespace Delights\Sage;

use Illuminate\Support\ServiceProvider;
use Delights\Sage\SageEvolution;

class SageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SageEvolution::class, function () {
            return new SageEvolution();
        });
    }
}
