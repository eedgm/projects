<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Work;
use App\Models\Status;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusWorksTest extends TestCase
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
    public function it_gets_status_works()
    {
        $status = Status::factory()->create();
        $works = Work::factory()
            ->count(2)
            ->create([
                'statu_id' => $status->id,
            ]);

        $response = $this->getJson(route('api.statuses.works.index', $status));

        $response->assertOk()->assertSee($works[0]->date_start);
    }

    /**
     * @test
     */
    public function it_stores_the_status_works()
    {
        $status = Status::factory()->create();
        $data = Work::factory()
            ->make([
                'statu_id' => $status->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.statuses.works.store', $status),
            $data
        );

        $this->assertDatabaseHas('works', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $work = Work::latest('id')->first();

        $this->assertEquals($status->id, $work->statu_id);
    }
}
