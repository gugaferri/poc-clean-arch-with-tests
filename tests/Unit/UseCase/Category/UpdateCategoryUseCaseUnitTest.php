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
    public function testRenameCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $name = 'Category Name';
        $descripton = 'Category Description';

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface
         */
        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $name,
            $descripton
        ]);
        $this->mockEntity->shouldReceive('update');
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));



        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|CategoryRepositoryInterface
         */
        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|UpdateCategoryInputDto
         */
        $this->mockInput = Mockery::mock(UpdateCategoryInputDto::class, [
            $uuid,
            'name updated'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        $this->assertInstanceOf(UpdateCategoryOutputDto::class, $response);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|CategoryRepositoryInterface
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);

        $useCase = new UpdateCategoryUseCase($this->spy);
        $response = $useCase->execute($this->mockInput);

        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');

        Mockery::close();

    }

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
        $category->shouldReceive('update');
        $category->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

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
