<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Interfaces\ProductRepositoryInterface;
use App\Modules\Products\Interfaces\ProductServiceInterface;
use App\Modules\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $repository) {}

    public function list($pageSize): LengthAwarePaginator
    {
        return $this->repository->all($pageSize);
    }

    public function show(int $id): Product
    {
        return $this->repository->find($id);
    }

    public function store(array $data): Product
    {
        return $this->repository->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->repository->update($product, $data);
    }

    public function destroy(Product $product): void
    {
        $this->repository->delete($product);
    }

    public function import(Collection $products): void
    {
        $this->repository->import($products);
    }
}
