<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New category',
            description: 'New description'
        );

        $this->assertNotEmpty($category->createdAt());
        $this->assertNotEmpty($category->id());
        $this->assertInstanceOf(ValueObjectUuid::class, $category->id);
        $this->assertEquals('New category', $category->name, 'Should be New category');
        $this->assertEquals('New description', $category->description, 'Should be New description');
        $this->assertEquals(true, $category->isActive);
    }

    public function testActivate()
    {
        $category = new Category(
            name: 'New category',
            description: 'New description',
            isActive: false
        );

        $this->assertFalse($category->isActive, 'Should be false');
        $category->activate();
        $this->assertTrue($category->isActive, 'Should be true');
    }

    public function testDisable()
    {
        $category = new Category(
            name: 'New category',
            description: 'New description',
            isActive: true
        );

        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'New category',
            description: 'New description',
            isActive: true,
            createdAt: '2023-01-01 08:00'
        );

        $category->update(
            name: 'Category Updated',
            description: 'Description Updated'
        );

        $this->assertEquals($uuid, $category->id());
        $this->assertEquals('Category Updated', $category->name);
        $this->assertEquals('Description Updated', $category->description);

    }

    public function testUpdateWithoutDescription()
    {
        $uuid = Uuid::uuid4()->toString();
        $category = new Category(
            id: $uuid,
            name: 'New category',
            description: 'New description',
            isActive: true
        );

        $category->update(name: 'Category Updated');

        $this->assertEquals($uuid, $category->id());
        $this->assertEquals('Category Updated', $category->name);
        $this->assertEquals('New description', $category->description);

    }

    public function testExceptionDescription()
    {
        try {
            $category = new Category(
                name: 'New',
                description: str_repeat('0', 256)
            );
            $this->assertTrue(false);
        } catch (\Throwable $throwable) {
            $this->assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }
}