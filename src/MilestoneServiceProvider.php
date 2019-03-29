<?php

namespace Encore\Milestone;

use Encore\Admin\Facades\Admin;
use Illuminate\Support\ServiceProvider;

class MilestoneServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Milestone $extension)
    {
        if (! Milestone::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'milestone');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/milestone/milestone')],
                'milestone-assets'
            );
        }
        if ($this->app->runningInConsole() && $migration = $extension->migrations()) {
            $this->publishes(
                [$migration => database_path('migrations')],
                'milestone-migrations'
            );
        }

        $this->app->booted(function () {
            Milestone::routes(__DIR__.'/../routes/web.php');
        });

        //需要引入静态文件时添加如下代码
        Admin::booting(function (){
//            Admin::js('vendor/milestone/milestone/js/dialog.js');
            Admin::js('vendor/milestone/milestone/js/dialog-plus.js');
            Admin::js('vendor/milestone/milestone/js/milestone.js');
            Admin::css('vendor/milestone/milestone/css/dialog.css');
        });
    }
}