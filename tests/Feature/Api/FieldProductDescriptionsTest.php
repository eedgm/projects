<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Field;
use App\Models\ProductDescription;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldProductDescriptionsTest extends TestCase
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
    public function it_gets_field_product_descriptions()
    {
        $field = Field::factory()->create();
        $productDescriptions = ProductDescription::factory()
            ->count(2)
            ->create([
                'field_id' => $field->id,
            ]);

        $response = $this->getJson(
            route('api.fields.product-descriptions.index', $field)
        );

        $response->assertOk()->assertSee($productDescriptions[0]->label);
    }

    /**
     * @test
     */
    public function it_stores_the_field_product_descriptions()
    {
        $field = Field::factory()->create();
        $data = ProductDescription::factory()
            ->make([
                'field_id' => $field->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.fields.product-descriptions.store', $field),
            $data
        );

        $this->assertDatabaseHas('product_descriptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productDescription = ProductDescription::latest('id')->first();

        $this->assertEquals($field->id, $productDescription->field_id);
    }
}
