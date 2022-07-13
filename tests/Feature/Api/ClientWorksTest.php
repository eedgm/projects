<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Work;
use App\Models\Client;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientWorksTest extends TestCase
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
    public function it_gets_client_works()
    {
        $client = Client::factory()->create();
        $works = Work::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(route('api.clients.works.index', $client));

        $response->assertOk()->assertSee($works[0]->date_start);
    }

    /**
     * @test
     */
    public function it_stores_the_client_works()
    {
        $client = Client::factory()->create();
        $data = Work::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.works.store', $client),
            $data
        );

        $this->assertDatabaseHas('works', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $work = Work::latest('id')->first();

        $this->assertEquals($client->id, $work->client_id);
    }
}
