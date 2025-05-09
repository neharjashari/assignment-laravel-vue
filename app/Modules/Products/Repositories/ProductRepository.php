<?php

namespace App\Modules\Products\Repositories;

use App\Modules\Products\Interfaces\ProductRepositoryInterface;
use App\Modules\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function all($pageSize): LengthAwarePaginator
    {
        return Product::paginate($pageSize);
    }

    public function find(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function import(Collection $products): void
    {
        $products->chunk(50)->each(function ($chunk) {
            foreach ($chunk as $apiProduct) {
                Product::updateOrCreate(
                    ['id' => $apiProduct['id']],
                    [
                        'title' => $apiProduct['title'],
                        'description' => $apiProduct['description'],
                        'price' => $apiProduct['price'],
                        'category' => $apiProduct['category'],
                        'image' => $apiProduct['image'],
                    ]
                );
            }
        });
    }
}
