<?php

namespace LumenRequestParser\Interfaces;

interface PaginationInterface
{
    public function setLimit(int $limit): void;
    public function getLimit(): ?int;

    public function setPage(int $page): void;
    public function getPage(): ?int;
}
