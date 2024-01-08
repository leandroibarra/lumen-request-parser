<?php

namespace LumenRequestParser\Traits;

use Illuminate\Http\Request;
use LumenRequestParser\Interfaces\RequestInterface;
use LumenRequestParser\Interfaces\RequestParserInterface;

// ResourceQueryParserTrait
trait RequestParserTrait
{
    protected function parseQueryParams(Request $request): RequestInterface
    {
        $parser = app(RequestParserInterface::class);

        return $parser->parse($request);
    }
}
