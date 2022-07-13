<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Status;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientStatusesTest extends TestCase
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
    public function it_gets_client_statuses()
    {
        $client = Client::factory()->create();
        $statuses = Status::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(
            route('api.clients.statuses.index', $client)
        );

        $response->assertOk()->assertSee($statuses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_client_statuses()
    {
        $client = Client::factory()->create();
        $data = Status::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.statuses.store', $client),
            $data
        );

        $this->assertDatabaseHas('statuses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $status = Status::latest('id')->first();

        $this->assertEquals($client->id, $status->client_id);
    }
}
