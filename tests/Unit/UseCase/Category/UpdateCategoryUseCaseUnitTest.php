<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\UpdateCategory\UpdateCategoryInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\UpdateCategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateCategoryUseCaseUnitTest extends TestCase
{
    public function testUpdateCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $name = 'Category Name';
        $descripton = 'Category Description';
        $isActive = false;

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface
         */
        $category = Mockery::mock(Category::class, [ $uuid, $name, $descripton, $isActive ]);
        $category->shouldReceive('id')->andReturn($uuid);
        $category->shouldReceive('name')->andReturn($name);
        $category->shouldReceive('descripton')->andReturn($descripton);
        $category->shouldReceive('isActive')->andReturn($isActive);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|CategoryRepositoryInterface
         */
        $repository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $repository->shouldReceive('findById')->andReturn($category);
        $repository->shouldReceive('update')->andReturn($category);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|UpdateCategoryInputDto
         */
        $updateCategoryInputDto = Mockery::mock(UpdateCategoryInputDto::class, [$uuid, $name . ' updated']);

        $updateCategoryUseCase = new UpdateCategoryUseCase($repository);
        $responseUpdateCategoryUseCase = $updateCategoryUseCase->execute($updateCategoryInputDto);

        $this->assertInstanceOf(UpdateCategoryOutputDto::class, $responseUpdateCategoryUseCase);
        $this->assertEquals($responseUpdateCategoryUseCase->name, $name);
        $this->assertEquals($responseUpdateCategoryUseCase->id, $uuid);

    }
}
