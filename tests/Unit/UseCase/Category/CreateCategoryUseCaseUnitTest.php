<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CreateCategoryInputDto;
use Core\UseCase\DTO\Category\CreateCategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Category Name';

        $this->mockCategory = Mockery::mock(Category::class, [$uuid, $categoryName]);
        $this->mockCategory->shouldReceive('id')->andReturn($uuid);

        $this->mockCategoryRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockCategoryRepository->shouldReceive('insert')->andReturn($this->mockCategory);

        $this->mockCreateCategoryDto = Mockery::mock(CreateCategoryInputDto::class, ['Category Name', 'Category Description']);

        $createCategoryUseCase = new CreateCategoryUseCase($this->mockCategoryRepository);
        $responseUseCase = $createCategoryUseCase->execute($this->mockCreateCategoryDto);

        $this->assertInstanceOf(CreateCategoryOutputDto::class, $responseUseCase);

        /**
         * Spies
         */
        $this->spy = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockCategory);
        $createCategoryUseCase = new CreateCategoryUseCase($this->spy);
        $responseUseCase = $createCategoryUseCase->execute($this->mockCreateCategoryDto);
        $this->spy->shouldHaveReceived('insert');


        Mockery::close();
    }
}
