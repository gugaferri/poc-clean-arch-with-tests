<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function insert(Category $category): Category;

    public function findById(string $id): Category;

    public function findAll(string $filter, string $order = 'ASC'): array;

    public function paginate(
        string $filter,
        string $order = 'ASC',
        int $page = 1,
        int $totalPerPage = 15): PaginationInterface;

    public function update(Category $category): Category;

    public function delete(string $id): bool;

    public function toCategory(object $data): Category;
}
