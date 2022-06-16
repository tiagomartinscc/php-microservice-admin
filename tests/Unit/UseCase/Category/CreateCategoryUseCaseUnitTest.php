<?php

namespace Tests\Unit\UseCase\Category;

use Core\UseCase\Category\CreateCategoryUseCase;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CategoryCreateOutputDto;
use Core\Domain\Entity\Category;
use PHPUnit\Framework\TestCase;
use Mockery;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $uuid = (string)Uuid::uuid4()->toString();
        $categoryName = 'Category Name';
        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockInput = Mockery::mock(CategoryCreateInputDto::class, [
            $uuid,
            $categoryName,
        ]);        
        //faz mock de uma classe qualquer que vai implementar a interface CategoryRepositoryInterface
        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInput);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->spy);
        $response = $useCase->execute($this->mockInput);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();

        $this->assertInstanceOf(CategoryCreateOutputDto::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals('', $response->description);
    }
}