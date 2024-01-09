<?php

namespace LumenRequestParser\Interfaces;

interface RequestInterface
{
    public function addFilter(FilterInterface $filter): void;
    public function hasFilter(): bool;
    public function getFilters(): array;

    public function addSort(SortInterface $sort): void;
    public function hasSort(): bool;
    public function getSorts(): array;

    public function addPagination(PaginationInterface $pagination): void;
    public function hasPagination(): bool;
    public function getPagination(): PaginationInterface;
}
