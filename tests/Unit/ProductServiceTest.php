<?php

namespace Tests\Unit\Modules\Products\Services;

use Tests\TestCase;
use Mockery;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Services\ProductService;
use App\Modules\Products\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductServiceTest extends TestCase
{
    protected ProductRepositoryInterface $mockRepository;
    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->mockRepository);
    }

    public function test_import_calls_repository_import()
    {
        $fakeProducts = collect([
            [
                'id' => 1,
                'title' => 'Test Product',
                'description' => 'Description',
                'price' => 9.99,
                'category' => 'Category',
                'image' => 'https://example.com/image.jpg',
            ]
        ]);

        $this->mockRepository
            ->shouldReceive('import')
            ->once()
            ->with($fakeProducts);

        $this->service->import($fakeProducts);

        $this->assertTrue(true);
    }

    public function test_list_returns_paginated_products()
    {
        $products = collect([
            new Product(['title' => 'Product 1']),
            new Product(['title' => 'Product 2']),
        ]);

        $paginator = new LengthAwarePaginator(
            $products,
            total: $products->count(),
            perPage: 10,
            currentPage: 1,
        );

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($paginator);

        $result = $this->service->list();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertEquals(2, $result->total());
        $this->assertEquals('Product 1', $result->items()[0]->title);
    }

    public function test_show_returns_product_by_id()
    {
        $product = new Product(['id' => 1, 'title' => 'Test']);

        $this->mockRepository
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($product);

        $result = $this->service->show(1);

        $this->assertEquals($product, $result);
    }

    public function test_store_creates_product()
    {
        $data = ['title' => 'New Product'];
        $product = new Product($data);

        $this->mockRepository
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($product);

        $result = $this->service->store($data);

        $this->assertEquals('New Product', $result->title);
    }

    public function test_update_updates_product()
    {
        $product = new Product(['id' => 1]);
        $data = ['title' => 'Updated'];
        $updatedProduct = new Product(array_merge(['id' => 1], $data));

        $this->mockRepository
            ->shouldReceive('update')
            ->once()
            ->with($product, $data)
            ->andReturn($updatedProduct);

        $result = $this->service->update($product, $data);

        $this->assertEquals('Updated', $result->title);
    }

    public function test_destroy_deletes_product()
    {
        $product = new Product(['id' => 1]);

        $this->mockRepository
            ->shouldReceive('delete')
            ->once()
            ->with($product);

        $this->service->destroy($product);

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
