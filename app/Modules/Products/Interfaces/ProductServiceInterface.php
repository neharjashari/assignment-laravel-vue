<?php

namespace App\Modules\Products\Interfaces;

use App\Modules\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    public function list($pageSize): LengthAwarePaginator;

    public function show(int $id): Product;

    public function store(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function destroy(Product $product): void;

    public function import(Collection $products): void;
}
