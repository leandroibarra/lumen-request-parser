<?php

namespace LumenRequestParser\Traits;

use Illuminate\Http\Request;
use LumenRequestParser\Interfaces\RequestInterface;
use LumenRequestParser\Interfaces\RequestParserInterface;

// ResourceQueryParserTrait
trait RequestParserTrait
{
    protected function parseQueryParams(Request $request, string $defaultSort, int $defaultLimit, int $defaultPage): RequestInterface
    {
        $parser = app(RequestParserInterface::class);

        return $parser->parse($request, $defaultSort, $defaultLimit, $defaultPage);
    }
}
