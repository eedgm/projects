<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ProductDescription;

use App\Models\Field;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDescriptionTest extends TestCase
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
    public function it_gets_product_descriptions_list()
    {
        $productDescriptions = ProductDescription::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.product-descriptions.index'));

        $response->assertOk()->assertSee($productDescriptions[0]->label);
    }

    /**
     * @test
     */
    public function it_stores_the_product_description()
    {
        $data = ProductDescription::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.product-descriptions.store'),
            $data
        );

        $this->assertDatabaseHas('product_descriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product_description()
    {
        $productDescription = ProductDescription::factory()->create();

        $product = Product::factory()->create();
        $field = Field::factory()->create();

        $data = [
            'label' => $this->faker->word,
            'product_id' => $product->id,
            'field_id' => $field->id,
        ];

        $response = $this->putJson(
            route('api.product-descriptions.update', $productDescription),
            $data
        );

        $data['id'] = $productDescription->id;

        $this->assertDatabaseHas('product_descriptions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product_description()
    {
        $productDescription = ProductDescription::factory()->create();

        $response = $this->deleteJson(
            route('api.product-descriptions.destroy', $productDescription)
        );

        $this->assertSoftDeleted($productDescription);

        $response->assertNoContent();
    }
}
