<?php

namespace DPodsiadlo\SvgCharts\Providers;

use DPodsiadlo\SvgCharts\SvgCharts;
use Illuminate\Support\ServiceProvider;

class SvgChartsProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views/', 'svg-charts');

        $this->publishes([
            __DIR__ . '/../../views/' => base_path('resources/views/vendor/svg-charts'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(SvgCharts::class, function () {
            return new SvgCharts();
        });
    }

    public function provides()
    {
        return [SvgCharts::class];
    }

}
