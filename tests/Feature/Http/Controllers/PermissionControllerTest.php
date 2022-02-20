<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PermissionController
 */
class PermissionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function permission_index_displays_view()
    {
        $permissions = Permission::factory()->count(3)->create();

        $response = $this->get(route('permission.index'));

        $response->assertOk();
        $response->assertViewIs('permission.index');
        $response->assertViewHas('permissions');
    }

    /**
     * @test
     */
    public function permission_store_saves_and_redirects()
    {
        $permission = Permission::factory()->makeOne();

        $response = $this->post(route('permission.store'), ['name' => $permission->name]);

        $response->assertRedirect(route('permission.index'));
        $response->assertSessionHas('permission.name', $permission->name);

        $this->assertDatabaseHas('permissions', ['name' => $permission->name]);
    }

    /**
     * @test
     */
    public function permission_create_displays_view()
    {
        $this->loginAsUser();
        $response = $this->get(route('permission.create'));

        $response->assertOk();
        $response->assertViewIs('permission.create');
    }

    /**
     * @test
     */
    public function permission_edit_displays_view()
    {
        $this->loginAsUser();
        $permission = Permission::factory()->create();

        $response = $this->get(route('permission.edit', $permission));

        $response->assertOk();
        $response->assertViewIs('permission.edit');
        $response->assertViewHas('permission');
    }

    /**
     * @test
     */
    public function permission_destroy_deletes_and_redirects()
    {
        $permission = Permission::factory()->create();

        $response = $this->delete(route('permission.destroy', $permission));

        $response->assertRedirect(route('permission.index'));

        $this->assertDatabaseMissing('permissions', $permission->toArray());
    }

    /**
     * @test
     */
    public function permission_update_saves_and_redirects()
    {
        $permission = Permission::factory()->create();

        $response = $this->patch(route('permission.update', $permission), ['name' => 'new_name']);

        $response->assertRedirect(route('permission.index'));

        $this->assertDatabaseHas('permissions', ['name' => 'new_name']);
    }
}
