<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Event;
use App\Models\Statu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventStatusTest extends TestCase
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
    public function it_gets_event_status()
    {
        $event = Event::factory()->create();
        $status = Statu::factory()
            ->count(2)
            ->create([
                'event_id' => $event->id,
            ]);

        $response = $this->getJson(route('api.events.status.index', $event));

        $response->assertOk()->assertSee($status[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_event_status()
    {
        $event = Event::factory()->create();
        $data = Statu::factory()
            ->make([
                'event_id' => $event->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.events.status.store', $event),
            $data
        );

        $this->assertDatabaseHas('status', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $statu = Statu::latest('id')->first();

        $this->assertEquals($event->id, $statu->event_id);
    }
}
