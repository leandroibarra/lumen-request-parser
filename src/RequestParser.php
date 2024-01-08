<?php

namespace LumenRequestParser;

use LumenRequestParser\Parameters\Request as RequestParameters;
use LumenRequestParser\Interfaces\RequestParserInterface;
use LumenRequestParser\Interfaces\RequestInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use LumenRequestParser\Parameters\Filter;
use LumenRequestParser\Parameters\Pagination;
use LumenRequestParser\Parameters\Connection;
use LumenRequestParser\Parameters\Sort;
use Illuminate\Http\Request;

// RequestQueryParser
class RequestParser implements RequestParserInterface
{
    protected $requestParams;

    public function __construct()
    {
        $this->requestParams = new RequestParameters();
    }

    public function parse(Request $request): RequestInterface
    {
        $this->parseFilters($request);
        $this->parseSort($request);
        $this->parsePagination($request);
        $this->parseConnections($request);

        return $this->requestParams;
    }

    protected function parseFilters(Request $request): void
    {
        $filters = $request->has('filter') ? $request->get('filter') : [];

        foreach (explode(',', $filters) as $filter) {
            $filterDatas = explode(':', $filter, 3);

            if (count($filterDatas) < 3) {
                throw new UnprocessableEntityHttpException('Filter must contains field and value!');
            }
            [$field, $operator, $value] = $filterDatas;

            $this->requestParams->addFilter(new Filter($field, $operator, $value));
        }
    }

    protected function parseSort(Request $request): void
    {
        $sorts = $request->has('sort') ? $request->get('sort') : [];

        foreach (explode(',', $sorts) as $sort) {
            if ($sort === '') {
                throw new UnprocessableEntityHttpException('Sort must contains field!');
            }

            $direction = $sort[0] === '-' ? 'DESC' : 'ASC';
            $field = in_array($sort[0], ['+', '-']) ? substr($sort, 1) : $sort;

            $this->requestParams->addSort(new Sort($field, $direction));
        }
    }

    protected function parsePagination(Request $request): void
    {
        if ($request->has('limit')) {
            $limit = (int) ($request->get('limit') ? $request->get('limit') : 10);
            $page = (int) ($request->has('page') ? $request->get('page') : 1);

            $this->requestParams->addPagination(new Pagination($limit, $page));
        }
    }

    protected function parseConnections($request): void
    {
        if ($request->has('connection')) {
            foreach ($request->get('connection') as $connection) {
                $this->requestParams->addConnection(new Connection($connection));
            }
        }
    }
}
