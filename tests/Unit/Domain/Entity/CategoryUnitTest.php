<?php

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Ramsey\Uuid\Uuid;

class CategoryUnitTest extends TestCase
{
    public function testAttribute() 
    {
        $category = new Category(
            name: 'New Cat',
            description: 'New desc',
            isActive: true
        );

        $this->assertNotEmpty($category->id);
        $this->assertNotEmpty($category->createdAt);
        $this->assertEquals('New Cat', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
        
    }
    
    public function testActiveted() 
    {
        $category = new Category(
            name: 'New Cat',
            isActive: false
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDisabled() 
    {
        $category = new Category(
            name: 'New Cat'
        );

        $this->assertTrue($category->isActive);
        $category->disabled();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate() 
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'New Cat',
            description: 'Nerw desc',
            isActive: true,
            createdAt: '2020-01-01 00:00:00'
        );

        $category->update(
            name: 'new_name',
            description: 'new_desc'
        );

        $this->assertEquals($uuid, $category->id);
        $this->assertNotEmpty($category->id);
        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new_desc', $category->description);
        $this->assertEquals('2020-01-01 00:00:00', $category->createdAt());
    }

    public function testExceptionName() {
        try {
            new Category(
                name: 'N',
                description: 'New desc'
            );
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription() {
        try {
            new Category(
                name: 'New',
                description: random_bytes(256)
            );
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}