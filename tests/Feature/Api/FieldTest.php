<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Field;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldTest extends TestCase
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
    public function it_gets_fields_list()
    {
        $fields = Field::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.fields.index'));

        $response->assertOk()->assertSee($fields[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_field()
    {
        $data = Field::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.fields.store'), $data);

        $this->assertDatabaseHas('fields', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.fields.update', $field), $data);

        $data['id'] = $field->id;

        $this->assertDatabaseHas('fields', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_field()
    {
        $field = Field::factory()->create();

        $response = $this->deleteJson(route('api.fields.destroy', $field));

        $this->assertSoftDeleted($field);

        $response->assertNoContent();
    }
}
