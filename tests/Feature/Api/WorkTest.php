<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Work;

use App\Models\Client;
use App\Models\Status;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkTest extends TestCase
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
    public function it_gets_works_list()
    {
        $works = Work::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.works.index'));

        $response->assertOk()->assertSee($works[0]->date_start);
    }

    /**
     * @test
     */
    public function it_stores_the_work()
    {
        $data = Work::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.works.store'), $data);

        $this->assertDatabaseHas('works', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_work()
    {
        $work = Work::factory()->create();

        $client = Client::factory()->create();
        $product = Product::factory()->create();
        $status = Status::factory()->create();

        $data = [
            'date_start' => $this->faker->date,
            'date_end' => $this->faker->date,
            'hours' => $this->faker->randomNumber(2),
            'cost' => $this->faker->randomNumber(2),
            'client_id' => $client->id,
            'product_id' => $product->id,
            'statu_id' => $status->id,
        ];

        $response = $this->putJson(route('api.works.update', $work), $data);

        $data['id'] = $work->id;

        $this->assertDatabaseHas('works', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_work()
    {
        $work = Work::factory()->create();

        $response = $this->deleteJson(route('api.works.destroy', $work));

        $this->assertSoftDeleted($work);

        $response->assertNoContent();
    }
}
