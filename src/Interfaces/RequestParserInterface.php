<?php

namespace LumenRequestParser\Interfaces;

use Illuminate\Http\Request;

// RequestQueryParserInterface
interface RequestParserInterface
{
    public function parse(Request $request, string $defaultSort, int $defaultLimit, int $defaultPage): RequestInterface;
}
