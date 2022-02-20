<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $users = User::factory()->count(3)->create();

        $response = $this->get(route('user.index'));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $email = $this->faker->safeEmail;
        $password = $this->faker->password;
        $name = $this->faker->name;

        $this->withoutExceptionHandling();

        $response = $this->post(route('user.store'), [
            'email' => $email,
            'password' => $password,
            'name' => $name,
        ]);

        $users = User::query()
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $users);
        $user = $users->first();

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('user.name', $user->name . ' added');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('user.create'));

        $response->assertOk();
        $response->assertViewIs('user.create');
    }

    /**
     * @test
     */
    public function edit_displays_view()
    {
        $user = User::factory()->create();

        $response = $this->get(route('user.edit', $user));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }

    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('user.destroy', $user));

        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * @test
     */
    public function update_saves_and_redirects()
    {
        $user = User::factory()->create();

        $name = $this->faker->name;

        $response = $this->put(route('user.update', $user), [
            'name' => $name,
        ]);

        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', [ 'name' => $name ]);
    }
}
