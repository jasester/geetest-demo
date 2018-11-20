<?php

namespace Hnndy\GeetestTool;

use Illuminate\Support\ServiceProvider;

class GeetestToolServiceProvider extends ServiceProvider
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [

    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //发布配置文件
        $this->publishes([
            __DIR__.'/../config' => config_path()
        ], 'geetest');

        //发布js
        $this->publishes([
            __DIR__ . '/../views/js' => public_path('vendor/captcha'),
        ], 'public');

        //发布视图
        $this->publishes([
            __DIR__ . '/../views/captcha' => base_path('resources/views/vendor/captcha'),
        ]);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRouteMiddleware();
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        $this->app->singleton('geetest', function () {
            return new GeetestTool();
        });
    }
}
