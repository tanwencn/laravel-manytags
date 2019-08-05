<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2017/10/12 11:02
 */

namespace Tanwencn\Manytags;

use Illuminate\Support\ServiceProvider;

class ManytagsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations')
            ], 'manytags');
        }
    }
}
