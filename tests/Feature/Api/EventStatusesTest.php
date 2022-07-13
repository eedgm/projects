<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Event;
use App\Models\Status;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventStatusesTest extends TestCase
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
    public function it_gets_event_statuses()
    {
        $event = Event::factory()->create();
        $statuses = Status::factory()
            ->count(2)
            ->create([
                'event_id' => $event->id,
            ]);

        $response = $this->getJson(route('api.events.statuses.index', $event));

        $response->assertOk()->assertSee($statuses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_event_statuses()
    {
        $event = Event::factory()->create();
        $data = Status::factory()
            ->make([
                'event_id' => $event->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.events.statuses.store', $event),
            $data
        );

        $this->assertDatabaseHas('statuses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $status = Status::latest('id')->first();

        $this->assertEquals($event->id, $status->event_id);
    }
}
