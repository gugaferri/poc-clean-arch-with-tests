<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\UpdateCategory\UpdateCategoryInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\UpdateCategoryOutputDto;

class UpdateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) { }

    public function execute(UpdateCategoryInputDto $updateCategoryInputDto): UpdateCategoryOutputDto
    {
        $category = $this->repository->findById($updateCategoryInputDto->id);
        $category->update(
            $updateCategoryInputDto->name,
            $updateCategoryInputDto->description ?? $category->description
        );

        $category = $this->repository->update($category);

        return new UpdateCategoryOutputDto(
            $category->id,
            $category->name,
            $category->description,
            $category->isActive
        );
    }
}
