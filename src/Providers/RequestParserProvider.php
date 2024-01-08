<?php

namespace LumenRequestParser\Providers;

use Illuminate\Support\ServiceProvider;
use LumenRequestParser\RequestParser;
use LumenRequestParser\Interfaces\RequestParserInterface;

class RequestParserProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RequestParserInterface::class, function () {
            return new RequestParser();
        });
    }
}
