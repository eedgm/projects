<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Work;

use App\Models\Client;
use App\Models\Status;
use App\Models\Product;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_works()
    {
        $works = Work::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('works.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.works.index')
            ->assertViewHas('works');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_work()
    {
        $response = $this->get(route('works.create'));

        $response->assertOk()->assertViewIs('app.works.create');
    }

    /**
     * @test
     */
    public function it_stores_the_work()
    {
        $data = Work::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('works.store'), $data);

        $this->assertDatabaseHas('works', $data);

        $work = Work::latest('id')->first();

        $response->assertRedirect(route('works.edit', $work));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_work()
    {
        $work = Work::factory()->create();

        $response = $this->get(route('works.show', $work));

        $response
            ->assertOk()
            ->assertViewIs('app.works.show')
            ->assertViewHas('work');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_work()
    {
        $work = Work::factory()->create();

        $response = $this->get(route('works.edit', $work));

        $response
            ->assertOk()
            ->assertViewIs('app.works.edit')
            ->assertViewHas('work');
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

        $response = $this->put(route('works.update', $work), $data);

        $data['id'] = $work->id;

        $this->assertDatabaseHas('works', $data);

        $response->assertRedirect(route('works.edit', $work));
    }

    /**
     * @test
     */
    public function it_deletes_the_work()
    {
        $work = Work::factory()->create();

        $response = $this->delete(route('works.destroy', $work));

        $response->assertRedirect(route('works.index'));

        $this->assertSoftDeleted($work);
    }
}
