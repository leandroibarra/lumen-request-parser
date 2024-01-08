<?php

namespace LumenRequestParser\Parameters;

use LumenRequestParser\Interfaces\RequestInterface;
use LumenRequestParser\Interfaces\FilterInterface;
use LumenRequestParser\Interfaces\SortInterface;
use LumenRequestParser\Interfaces\PaginationInterface;
use LumenRequestParser\Interfaces\ConnectionInterface;

class Request implements RequestInterface
{
    protected $filters = [];
    protected $sorts = [];
    protected $pagination;
    protected $connections = [];

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

    public function addConnection(ConnectionInterface $connection): void
    {
        $this->connections[] = $connection;
    }

    public function hasConnection(): bool
    {
        return (bool) count($this->connections);
    }

    public function getConnections(): array
    {
        return $this->connections;
    }
}
