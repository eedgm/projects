<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductDescription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductDescriptionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_product_product_descriptions()
    {
        $product = Product::factory()->create();
        $productDescriptions = ProductDescription::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.product-descriptions.index', $product)
        );

        $response->assertOk()->assertSee($productDescriptions[0]->label);
    }

    /**
     * @test
     */
    public function it_stores_the_product_product_descriptions()
    {
        $product = Product::factory()->create();
        $data = ProductDescription::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.product-descriptions.store', $product),
            $data
        );

        $this->assertDatabaseHas('product_descriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productDescription = ProductDescription::latest('id')->first();

        $this->assertEquals($product->id, $productDescription->product_id);
    }
}
