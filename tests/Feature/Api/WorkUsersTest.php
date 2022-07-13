<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Work;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkUsersTest extends TestCase
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
    public function it_gets_work_users()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();

        $work->users()->attach($user);

        $response = $this->getJson(route('api.works.users.index', $work));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_work()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.works.users.store', [$work, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $work
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_work()
    {
        $work = Work::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.works.users.store', [$work, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $work
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
