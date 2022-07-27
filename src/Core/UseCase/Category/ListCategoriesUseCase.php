<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDto;

class ListCategoriesUseCase
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {}

    public function execute(ListCategoriesInputDto $listCategoriesInputDto): ListCategoriesOutputDto
    {
        $categories = $this->repository->paginate(
            filter: $listCategoriesInputDto->filter,
            order: $listCategoriesInputDto->order,
            page: $listCategoriesInputDto->page,
            totalPerPage: $listCategoriesInputDto->totalPerPage
        );

        return new ListCategoriesOutputDto(
            $categories->items(),
            $categories->total(),
            $categories->lastPage(),
            $categories->firstPage(),
            $categories->currentPage(),
            $categories->perPage(),
            $categories->to(),
            $categories->from()
        );
    }
}
