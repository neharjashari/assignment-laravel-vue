<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Interfaces\ProductServiceInterface;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Requests\StoreProductRequest;
use App\Modules\Products\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(protected ProductServiceInterface $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->service->store($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function show(string $id)
    {
        return response()->json($this->service->show((int) $id));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = $this->service->update($product, $request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $updated
        ]);
    }

    public function destroy(Product $product)
    {
        $this->service->destroy($product);

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
