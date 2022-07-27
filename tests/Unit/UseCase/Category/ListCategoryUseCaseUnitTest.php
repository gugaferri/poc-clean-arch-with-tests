<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {

        $id = (string) Uuid::uuid4()->toString();
        $this->mockCategory = Mockery::mock(Category::class, [
            $id,
            'teste category'
        ]);
        $this->mockCategory->shouldReceive('id')->andReturn($id);
        $this->mockCategory->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));


        $this->mockCategoryRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockCategoryRepository
            ->shouldReceive('findById')
            ->with($id)
            ->andReturn($this->mockCategory);

        $this->mockCategoryInputDto = Mockery::mock(CategoryInputDto::class, [
            $id,
        ]);

        $listCategoryUseCase = new ListCategoryUseCase($this->mockCategoryRepository);
        $response = $listCategoryUseCase->execute($this->mockCategoryInputDto);

        $this->assertInstanceOf(CategoryOutputDto::class, $response);
        $this->assertEquals('teste category', $response->name);
        $this->assertEquals($id, $response->id);

        $this->spy = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockCategory);

        $listCategoryUseCase = new ListCategoryUseCase($this->spy);
        $response = $listCategoryUseCase->execute($this->mockCategoryInputDto);
        $this->spy->shouldHaveReceived('findById');


    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
