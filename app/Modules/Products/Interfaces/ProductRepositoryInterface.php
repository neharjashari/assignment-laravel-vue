<?php

namespace App\Modules\Products\Interfaces;

use App\Modules\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function all(): LengthAwarePaginator;

    public function find(int $id): Product;

    public function create(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function delete(Product $product): void;

    public function import(Collection $products): void;
}
