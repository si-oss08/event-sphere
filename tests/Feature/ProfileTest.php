<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_their_profile_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertSee($user->email);
    }

    public function test_user_can_update_their_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name' => 'Nama Diperbarui',
                'email' => 'diperbarui@example.com',
                'phone' => '081234567890',
                'bio' => 'Bio yang diperbarui melalui pengujian.',
            ])
            ->assertRedirect(route('profile.edit'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Diperbarui',
            'email' => 'diperbarui@example.com',
        ]);
    }

    public function test_profile_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'sudah-dipakai@example.com']);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name' => $user->name,
                'email' => 'sudah-dipakai@example.com',
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors('email');

        $this->assertNotSame('sudah-dipakai@example.com', $user->fresh()->email);
    }

    public function test_avatar_url_uses_the_configured_public_disk_url(): void
    {
        config(['filesystems.disks.public.url' => 'https://cdn.eventsphere.test/storage']);

        $user = User::factory()->create(['avatar_path' => 'avatars/budi.jpg']);

        $this->assertSame('https://cdn.eventsphere.test/storage/avatars/budi.jpg', $user->avatarUrl());
    }

    public function test_user_can_upload_an_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
            ])
            ->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertNotNull($user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
    }

    public function test_guest_cannot_access_profile_page(): void
    {
        $this->get(route('profile.edit'))->assertRedirect(route('login'));
    }
}
