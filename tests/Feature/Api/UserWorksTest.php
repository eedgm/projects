<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Work;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserWorksTest extends TestCase
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
    public function it_gets_user_works()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();

        $user->works()->attach($work);

        $response = $this->getJson(route('api.users.works.index', $user));

        $response->assertOk()->assertSee($work->date_start);
    }

    /**
     * @test
     */
    public function it_can_attach_works_to_user()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();

        $response = $this->postJson(
            route('api.users.works.store', [$user, $work])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->works()
                ->where('works.id', $work->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_works_from_user()
    {
        $user = User::factory()->create();
        $work = Work::factory()->create();

        $response = $this->deleteJson(
            route('api.users.works.store', [$user, $work])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->works()
                ->where('works.id', $work->id)
                ->exists()
        );
    }
}
