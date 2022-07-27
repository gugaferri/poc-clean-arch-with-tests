<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CreateCategoryInputDto;
use Core\UseCase\DTO\Category\CreateCategoryOutputDto;

class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    )
    {}

    public function execute(CreateCategoryInputDto $input): CreateCategoryOutputDto
    {
        $category = new Category(
            name: $input->name,
            description: $input->description,
            isActive: $input->isActive
        );

        $output = $this->repository->insert($category);

        return new CreateCategoryOutputDto(
            id: $output->id(),
            name: $output->name,
            description: $output->description,
            is_active: $output->isActive);
    }
}
