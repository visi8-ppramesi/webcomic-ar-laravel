<?php

namespace App\Providers;

use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $fuckShit = explode('://', env('APP_URL'));
        $url->forceRootUrl(env('APP_URL'));
        $url->forceScheme($fuckShit[0]);
        if(env('APP_ENV') == 'local'){
            Paginator::currentPathResolver(function (){
                $requestUrl = app('request')->url();
                $boom = explode('://', $requestUrl);
                $url = explode('/', $boom[1]);
                array_shift($url);
                array_unshift($url, env('APP_URL'));
                return implode('/', $url);
            });

            Paginator::currentPageResolver(function ($pageName = 'page'){
                $page = app('request')->input($pageName);

                if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                    return (int) $page;
                }

                return 1;
            });

            Paginator::queryStringResolver(function (){
                return app('request')->query();
            });

            CursorPaginator::currentCursorResolver(function ($cursorName = 'cursor'){
                return Cursor::fromEncoded(app('request')->input($cursorName));
            });

        }
    }
}
