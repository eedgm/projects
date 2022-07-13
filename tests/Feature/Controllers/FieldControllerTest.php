<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Field;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldControllerTest extends TestCase
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
    public function it_displays_index_view_with_fields()
    {
        $fields = Field::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('fields.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.fields.index')
            ->assertViewHas('fields');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_field()
    {
        $response = $this->get(route('fields.create'));

        $response->assertOk()->assertViewIs('app.fields.create');
    }

    /**
     * @test
     */
    public function it_stores_the_field()
    {
        $data = Field::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('fields.store'), $data);

        $this->assertDatabaseHas('fields', $data);

        $field = Field::latest('id')->first();

        $response->assertRedirect(route('fields.edit', $field));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_field()
    {
        $field = Field::factory()->create();

        $response = $this->get(route('fields.show', $field));

        $response
            ->assertOk()
            ->assertViewIs('app.fields.show')
            ->assertViewHas('field');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_field()
    {
        $field = Field::factory()->create();

        $response = $this->get(route('fields.edit', $field));

        $response
            ->assertOk()
            ->assertViewIs('app.fields.edit')
            ->assertViewHas('field');
    }

    /**
     * @test
     */
    public function it_updates_the_field()
    {
        $field = Field::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'html' => $this->faker->randomHtml,
            'enable' => $this->faker->numberBetween(0, 127),
            'preview' => $this->faker->text,
        ];

        $response = $this->put(route('fields.update', $field), $data);

        $data['id'] = $field->id;

        $this->assertDatabaseHas('fields', $data);

        $response->assertRedirect(route('fields.edit', $field));
    }

    /**
     * @test
     */
    public function it_deletes_the_field()
    {
        $field = Field::factory()->create();

        $response = $this->delete(route('fields.destroy', $field));

        $response->assertRedirect(route('fields.index'));

        $this->assertSoftDeleted($field);
    }
}
