<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RoleController
 */
class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function role_index_displays_view()
    {
        $roles = Role::factory()->count(3)->create();

        $response = $this->get(route('role.index'));

        $response->assertOk();
        $response->assertViewIs('role.index');
        $response->assertViewHas('roles');
    }

    /**
     * @test
     */
    public function role_store_saves_and_redirects()
    {
        $role = Role::factory()->makeOne();

        $this->assertDatabaseMissing('roles', ['name' => $role->name]);

        $response = $this->post(route('role.store'), $role->toArray());

        $response->assertRedirect(route('role.index'));
        $response->assertSessionHas('role.name', $role->name);

        $this->assertDatabaseHas('roles', [ 'name' => $role->name ]);
    }

    /**
     * @test
     */
    public function role_create_displays_view()
    {
        $this->loginAsUser();
        $response = $this->get(route('role.create'));

        $response->assertOk();
        $response->assertViewIs('role.create');
    }

    /**
     * @test
     */
    public function role_edit_displays_view()
    {
        $this->loginAsUser();
        $role = Role::factory()->create();

        $response = $this->get(route('role.edit', $role));

        $response->assertOk();
        $response->assertViewIs('role.edit');
        $response->assertViewHas('role');
    }

    /**
     * @test
     */
    public function role_destroy_deletes_and_redirects()
    {
        $role = Role::factory()->create();

        $response = $this->delete(route('role.destroy', $role));

        $response->assertRedirect(route('role.index'));

        $this->assertDatabaseMissing('roles', ['name' => $role->name]);
    }

    /**
     * @test
     */
    public function role_update_saves_and_redirects()
    {
        $role = Role::factory()->create();

        $response = $this->put(route('role.update', $role), ['name' => 'new_name']);

        $response->assertRedirect(route('role.index'));

        $this->assertDatabaseHas('roles', [ 'name' => 'new_name' ]);
    }
}
