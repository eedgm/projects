<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Work;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductWorksTest extends TestCase
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
    public function it_gets_product_works()
    {
        $product = Product::factory()->create();
        $works = Work::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(route('api.products.works.index', $product));

        $response->assertOk()->assertSee($works[0]->date_start);
    }

    /**
     * @test
     */
    public function it_stores_the_product_works()
    {
        $product = Product::factory()->create();
        $data = Work::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.works.store', $product),
            $data
        );

        $this->assertDatabaseHas('works', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $work = Work::latest('id')->first();

        $this->assertEquals($product->id, $work->product_id);
    }
}
