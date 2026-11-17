<?php

namespace Tests\Feature;

use App\EventStatus;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_category(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Kategori Baru',
            'description' => 'Kategori yang dibuat melalui pengujian.',
            'color' => '#fbbf24',
        ]);

        $response->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Kategori Baru',
            'slug' => 'kategori-baru',
        ]);
    }

    public function test_category_name_must_be_unique(): void
    {
        $admin = User::factory()->admin()->create();
        Category::factory()->create(['name' => 'Teknologi']);

        $response = $this->actingAs($admin)
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), [
                'name' => 'Teknologi',
                'color' => '#fbbf24',
            ]);

        $response->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');

        $this->assertSame(1, Category::query()->where('name', 'Teknologi')->count());
    }

    public function test_admin_can_update_a_category(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Nama Lama']);

        $this->actingAs($admin)
            ->put(route('admin.categories.update', $category), [
                'name' => 'Nama Baru',
                'description' => 'Deskripsi kategori yang diperbarui.',
                'color' => '#e11d48',
            ])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Nama Baru',
            'slug' => 'nama-baru',
            'color' => '#e11d48',
        ]);
    }

    public function test_deleting_a_category_keeps_its_events(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $event = Event::factory()->create(['category_id' => $category->id]);

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'category_id' => null,
        ]);
    }

    public function test_admin_can_change_another_users_role(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->participant()->create();

        $this->actingAs($admin)
            ->patch(route('admin.users.update', $user), [
                'role' => UserRole::Organizer->value,
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertSame(UserRole::Organizer, $user->role);
        $this->assertNotNull($user->organization_name);
    }

    public function test_admin_cannot_demote_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.users.index'))
            ->patch(route('admin.users.update', $admin), [
                'role' => UserRole::Participant->value,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('error');

        $this->assertSame(UserRole::Admin, $admin->fresh()->role);
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', $admin))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_another_user(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->participant()->create();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_change_an_event_status(): void
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();

        $this->actingAs($admin)
            ->patch(route('admin.events.status', $event), [
                'status' => EventStatus::Completed->value,
            ])
            ->assertRedirect();

        $this->assertSame(EventStatus::Completed, $event->fresh()->status);
    }

    public function test_admin_can_delete_an_event_with_its_registrations(): void
    {
        $admin = User::factory()->admin()->create();
        $event = Event::factory()->create();
        $registration = Registration::factory()->for($event)->create();

        $this->actingAs($admin)
            ->delete(route('admin.events.destroy', $event))
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        $this->assertDatabaseMissing('registrations', ['id' => $registration->id]);
    }
}
