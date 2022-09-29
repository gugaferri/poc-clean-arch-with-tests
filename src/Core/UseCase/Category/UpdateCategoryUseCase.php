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

        $categoryUpdated = $this->repository->update($category);

        return new UpdateCategoryOutputDto(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            isActive: $categoryUpdated->isActive,
            created_at: $categoryUpdated->createdAt()
        );
    }
}
