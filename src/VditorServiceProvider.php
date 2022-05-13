<?php

namespace Jatdung\DcatVditor;

use Dcat\Admin\Admin;
use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Form;
use Illuminate\Routing\Router;

class VditorServiceProvider extends ServiceProvider
{
    public function init()
    {
        $this->registerRoute();
        $this->loadViewsFrom($this->getViewPath(), 'vditor');

        Admin::booting(function () {
            Admin::asset()->alias('@vditor', [
                'js'  => '@extension/' . $this->getPackageName() . '/index.min.js',
                'css' => '@extension/' . $this->getPackageName() . '/index.css'
            ]);
            Form::extend('vditor', Vditor::class);
        });
    }


    protected function registerRoute()
    {
        $this->registerRoutes(function (Router $router) {
            $router->post('/vditor/upload', 'VditorController@upload')->name('vditor.upload');
        });
    }
}