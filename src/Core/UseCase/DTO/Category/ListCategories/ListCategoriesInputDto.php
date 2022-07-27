<?php

namespace Core\UseCase\DTO\Category\ListCategories;

class ListCategoriesInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'ASC',
        public int $page = 1,
        public int $totalPerPage = 15
    ) {}
}
