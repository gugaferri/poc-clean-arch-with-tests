<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoriesUseCaseUnitTest extends TestCase
{
    public function testListCategoriesEmpty()
    {
        $mockPagination = $this->mockPagination([]);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|CategoryRepositoryInterface
         */
        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|ListCategoriesInputDto
         */
        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'asc']);

        $useCase = new ListCategoriesUseCase($mockRepo);

        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(ListCategoriesOutputDto::class, $responseUseCase);

        $this->assertEquals(0, $responseUseCase->total);
        $this->assertCount(0, $responseUseCase->items);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|CategoryRepositoryInterface
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase =  new ListCategoriesUseCase($this->spy);
        $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('paginate');

    }

    public function testListCategories()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->name = 'name';
        $register->description = 'description';
        $register->is_active = 'is_active';
        $register->created_at = 'created_at';
        $register->updated_at = 'updated_at';
        $register->deleted_at = 'deleted_at';

        $mockPagination = $this->mockPagination([$register]);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|CategoryRepositoryInterface
         */
        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);

        $mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|ListCategoriesInputDto
         */
        $this->mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter', 'asc']);

        $useCase = new ListCategoriesUseCase($mockRepo);

        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertCount(1, $responseUseCase->items);
        $this->assertInstanceOf(stdClass::class, $responseUseCase->items[0]);
        $this->assertInstanceOf(ListCategoriesOutputDto::class, $responseUseCase);
    }

    protected function mockPagination(array $itens = [])
    {
        /**
         * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface
         */
        $mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);
        $mockPagination->shouldReceive('items')->andReturn($itens);
        $mockPagination->shouldReceive('total')->andReturn(0);
        $mockPagination->shouldReceive('lastPage')->andReturn(0);
        $mockPagination->shouldReceive('firstPage')->andReturn(0);
        $mockPagination->shouldReceive('currentPage')->andReturn(0);
        $mockPagination->shouldReceive('perPage')->andReturn(0);
        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);

        return $mockPagination;
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
