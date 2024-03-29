<?php

namespace LumenRequestParser\Parameters;

use LumenRequestParser\Interfaces\RequestInterface;
use LumenRequestParser\Interfaces\FilterInterface;
use LumenRequestParser\Interfaces\SortInterface;
use LumenRequestParser\Interfaces\PaginationInterface;
use LumenRequestParser\Interfaces\ParameterInterface;

class Request implements RequestInterface
{
    protected $filters = [];
    protected $sorts = [];
    protected $pagination;
    protected $parameters = [];

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    public function hasFilter(): bool
    {
        return (bool) count($this->filters);
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addSort(SortInterface $sort): void
    {
        $this->sorts[] = $sort;
    }

    public function hasSort(): bool
    {
        return (bool) count($this->sorts);
    }

    public function getSorts(): array
    {
        return $this->sorts;
    }

    public function addPagination(PaginationInterface $pagination): void
    {
        $this->pagination = $pagination;
    }

    public function hasPagination(): bool
    {
        return $this->pagination !== null;
    }

    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }

    public function hasParameters(): bool
    {
        return $this->parameters !== null;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameter(ParameterInterface $parameter): void
    {
        $this->parameters[] = $parameter;
    }
}
