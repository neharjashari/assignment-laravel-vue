<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Products\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_products_command_imports_products()
    {
        Http::fake([
            'fakestoreapi.com/*' => Http::response([
                [
                    'id' => 1,
                    'title' => 'Imported Product',
                    'description' => 'Test Description',
                    'price' => 9.99,
                    'category' => 'Test Category',
                    'image' => 'https://example.com/image.jpg',
                ]
            ]),
        ]);

        $this->artisan('app:import-products')
            ->expectsOutput('Products imported/synced successfully.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('products', [
            'id' => 1,
            'title' => 'Imported Product',
        ]);
    }

    public function test_authenticated_user_can_update_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $payload = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'price' => 19.99,
            'image' => 'https://example.com/updated.jpg',
        ];

        $this->actingAs($user)
            ->putJson("/api/products/{$product->id}", $payload)
            ->assertOk()
            ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_guest_cannot_update_product()
    {
        $product = Product::factory()->create();

        $this->putJson("/api/products/{$product->id}", [
            'title' => 'Should Fail',
        ])->assertUnauthorized();
    }
}
