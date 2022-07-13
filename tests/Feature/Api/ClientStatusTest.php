<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Statu;
use App\Models\Client;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientStatusTest extends TestCase
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
    public function it_gets_client_status()
    {
        $client = Client::factory()->create();
        $status = Statu::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(route('api.clients.status.index', $client));

        $response->assertOk()->assertSee($status[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_client_status()
    {
        $client = Client::factory()->create();
        $data = Statu::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.status.store', $client),
            $data
        );

        $this->assertDatabaseHas('status', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $statu = Statu::latest('id')->first();

        $this->assertEquals($client->id, $statu->client_id);
    }
}
