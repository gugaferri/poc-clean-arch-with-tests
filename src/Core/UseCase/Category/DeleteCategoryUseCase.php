<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\DeleteCategory\DeleteCategoryOutputDto;

class DeleteCategoryUseCase
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    )
    {}

    public function execute(CategoryInputDto $input): DeleteCategoryOutputDto
    {

        $response = $this->repository->delete($input->id);

        return new DeleteCategoryOutputDto($response);
    }
}
