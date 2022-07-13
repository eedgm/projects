<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ProductDescription;

use App\Models\Field;
use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductDescriptionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_product_descriptions()
    {
        $productDescriptions = ProductDescription::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('product-descriptions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.product_descriptions.index')
            ->assertViewHas('productDescriptions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product_description()
    {
        $response = $this->get(route('product-descriptions.create'));

        $response->assertOk()->assertViewIs('app.product_descriptions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product_description()
    {
        $data = ProductDescription::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('product-descriptions.store'), $data);

        $this->assertDatabaseHas('product_descriptions', $data);

        $productDescription = ProductDescription::latest('id')->first();

        $response->assertRedirect(
            route('product-descriptions.edit', $productDescription)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product_description()
    {
        $productDescription = ProductDescription::factory()->create();

        $response = $this->get(
            route('product-descriptions.show', $productDescription)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.product_descriptions.show')
            ->assertViewHas('productDescription');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product_description()
    {
        $productDescription = ProductDescription::factory()->create();

        $response = $this->get(
            route('product-descriptions.edit', $productDescription)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.product_descriptions.edit')
            ->assertViewHas('productDescription');
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

        $response = $this->put(
            route('product-descriptions.update', $productDescription),
            $data
        );

        $data['id'] = $productDescription->id;

        $this->assertDatabaseHas('product_descriptions', $data);

        $response->assertRedirect(
            route('product-descriptions.edit', $productDescription)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_product_description()
    {
        $productDescription = ProductDescription::factory()->create();

        $response = $this->delete(
            route('product-descriptions.destroy', $productDescription)
        );

        $response->assertRedirect(route('product-descriptions.index'));

        $this->assertSoftDeleted($productDescription);
    }
}
