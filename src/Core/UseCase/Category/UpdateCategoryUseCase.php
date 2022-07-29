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
        $this->repository->findById($updateCategoryInputDto->uuid);

        $category = $this->repository->update(
            new Category($updateCategoryInputDto->uuid, $updateCategoryInputDto->name)
        );

        return new UpdateCategoryOutputDto($category->id(), $category->name);
    }
}
