<?php

namespace Jatdung\DcatVditor;

use Dcat\Admin\Admin;
use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Form;
use Illuminate\Routing\Router;
use Jatdung\DcatVditor\Controllers\VditorController;

class VditorServiceProvider extends ServiceProvider
{
    public function init()
    {
        $this->registerRoute();
        $this->defineView();

        Admin::booting(function () {
            Admin::asset()->alias('@vditor', [
                'js'  => '@extension/' . $this->getPackageName() . '/dist/index.min.js',
                'css' => '@extension/' . $this->getPackageName() . '/dist/index.css'
            ]);
            Form::extend('vditor', Vditor::class);
        });
    }


    protected function registerRoute()
    {
        $this->registerRoutes(function (Router $router) {
            $router->post('/vditor/upload', VditorController::class . '@upload')->name('vditor.upload');
        });
    }

    protected function defineView()
    {
        $this->loadViewsFrom($this->getViewPath(), 'dcat-vditor');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dcat-vditor')
        ], 'dcat-vditor-view');
    }
}