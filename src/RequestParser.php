<?php

namespace LumenRequestParser;

use LumenRequestParser\Parameters\Request as RequestParameters;
use LumenRequestParser\Interfaces\RequestParserInterface;
use LumenRequestParser\Interfaces\RequestInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use LumenRequestParser\Parameters\Filter;
use LumenRequestParser\Parameters\Parameter;
use LumenRequestParser\Parameters\Pagination;
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

    public function parse(Request $request, string $defaultSort, int $defaultLimit): RequestInterface
    {
        $this->parseFilters($request);
        $this->parseSort($request, $defaultSort);
        $this->parsePagination($request, $defaultLimit);

        return $this->requestParams;
    }

    protected function parseFilters(Request $request): void
    {
        if ($request->has('filter')) {
            foreach (explode(',', $request->get('filter')) as $filter) {
                $filterDatas = explode(':', $filter, 3);

                if (count($filterDatas) < 3) {
                    throw new UnprocessableEntityHttpException('Filter must contains field, operator, and value!');
                }
                [$field, $operator, $value] = $filterDatas;

                $this->requestParams->addFilter(new Filter($field, $operator, $value));
            }

            $this->requestParams->addParameter(new Parameter('filter', $request->get('filter')));
        }
    }

    protected function parseSort(Request $request, string $defaultSort): void
    {
        $sorts = $request->has('sort') ? $request->get('sort') : $defaultSort;

        if ($sorts) {
            foreach (explode(',', $sorts) as $sort) {
                if ($sort === '') {
                    throw new UnprocessableEntityHttpException('Sort must contains field!');
                }

                $direction = $sort[0] === '-' ? 'DESC' : 'ASC';
                $field = in_array($sort[0], ['+', '-']) ? substr($sort, 1) : $sort;

                $this->requestParams->addSort(new Sort($field, $direction));
            }

            if ($request->has('sort')) {
                $this->requestParams->addParameter(new Parameter('sort', $request->get('sort')));
            }
        }
    }

    protected function parsePagination(Request $request, int $defaultLimit): void
    {
        $limit = (int) $defaultLimit;
        $page = 1;

        if ($request->has('limit')) {
            $limit = (int) $request->get('limit');
            $this->requestParams->addParameter(new Parameter('limit', $limit));
        }

        if ($request->has('page')) {
            $page = (int) $request->get('page');
            $this->requestParams->addParameter(new Parameter('page', $page));
        }

        $this->requestParams->addPagination(new Pagination($limit, $page));
    }
}
