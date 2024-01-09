<?php

namespace LumenRequestParser\Traits;

use Illuminate\Http\Request;
use LumenRequestParser\Interfaces\RequestInterface;
use LumenRequestParser\Interfaces\RequestParserInterface;

// ResourceQueryParserTrait
trait RequestParserTrait
{
    protected function parseQueryParams(Request $request, array $options = []): RequestInterface
    {
        $parser = app(RequestParserInterface::class);

        $defaultSort = isset($options['sort']) ? $options['sort'] : 'id';
        $defaultLimit = isset($options['limit']) ? (int) $options['limit'] : 10;

        return $parser->parse($request, $defaultSort, $defaultLimit);
    }
}
