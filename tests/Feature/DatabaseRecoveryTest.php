<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use App\Models\ListWord;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DatabaseRecoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_compatible_user(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'full_name' => 'New Wordy User',
            'email' => 'new-user@wordy.local',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $user = User::where('email', 'new-user@wordy.local')->firstOrFail();
        $this->assertSame('New Wordy User', $user->full_name);
        $this->assertFalse($user->is_verified);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_verified_user_can_manage_lists_and_flashcards(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/list_word/add', [
                'title' => 'Test List',
                'description' => 'Created by feature test',
            ])
            ->assertRedirect(route('list-word'));

        $list = ListWord::where('title', 'Test List')->firstOrFail();

        $this->actingAs($user)
            ->get('/list_word')
            ->assertOk()
            ->assertSee('Test List');

        $this->actingAs($user)
            ->post('/flashcard/add', [
                'word' => 'restore',
                'definition' => 'to bring something back',
                'word_type' => 'verb',
                'pronunciation' => '/rɪˈstɔːr/',
                'example' => 'Restore the database.',
                'id_list' => $list->id,
            ])
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $flashcard = Flashcard::where('word', 'restore')->firstOrFail();

        $this->actingAs($user)
            ->get('/flashcard/list/'.$list->id)
            ->assertOk()
            ->assertSee('restore')
            ->assertSee('to bring something back');

        $this->actingAs($user)
            ->post('/flashcard/edit/'.$flashcard->id, [
                'word' => 'recovery',
                'definition' => 'the process of restoring data',
                'word_type' => 'noun',
                'pronunciaton' => '/rɪˈkʌvəri/',
                'example' => 'Database recovery succeeded.',
            ])
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $this->assertDatabaseHas('flashcards', [
            'id' => $flashcard->id,
            'word' => 'recovery',
            'definition' => 'the process of restoring data',
        ]);
    }

    public function test_deleting_a_list_cascades_to_its_flashcards(): void
    {
        $list = ListWord::factory()->create();
        $flashcard = Flashcard::factory()->create(['list_id' => $list->id]);

        $list->delete();

        $this->assertDatabaseMissing('flashcards', ['id' => $flashcard->id]);
    }

    public function test_password_reset_uses_password_reset_tokens_table(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post('/password/email', ['email' => $user->email])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_database_seeder_creates_demo_dataset(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'demo@wordy.local',
            'full_name' => 'Wordy Demo',
            'is_verified' => true,
        ]);
        $this->assertDatabaseCount('word_lists', 2);
        $this->assertDatabaseCount('flashcards', 10);
    }

    public function test_login_profile_bulk_create_search_and_delete_flows(): void
    {
        $user = User::factory()->create();
        $list = ListWord::factory()->create(['user_id' => $user->id]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('list-word'));

        $this->actingAs($user)
            ->post('/profile/edit-info', [
                'fullName' => 'Updated Demo User',
                'bio' => 'Updated profile biography.',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'full_name' => 'Updated Demo User',
            'bio' => 'Updated profile biography.',
        ]);

        $this->actingAs($user)
            ->post('/flashcard/adds', [
                'word' => ['schema', 'migration'],
                'definition' => ['database structure', 'database change'],
                'pronunciation' => [null, null],
                'word_type' => ['noun', 'noun'],
                'example1' => ['Define the schema.', 'Run the migration.'],
                'example2' => ['', ''],
                'id_list_words' => $list->id,
            ])
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $this->actingAs($user)
            ->get('/flashcard/search?list_id='.$list->id.'&search=schema')
            ->assertOk()
            ->assertSee('schema')
            ->assertDontSee('migration');

        $flashcard = Flashcard::where('word', 'schema')->firstOrFail();

        $this->actingAs($user)
            ->post('/flashcard/delete/'.$flashcard->id)
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $this->assertDatabaseMissing('flashcards', ['id' => $flashcard->id]);

        $this->actingAs($user)
            ->post('/list_word/delete', ['list_id' => $list->id])
            ->assertRedirect(route('list-word'));

        $this->assertDatabaseMissing('word_lists', ['id' => $list->id]);
        $this->assertDatabaseMissing('flashcards', ['word' => 'migration']);
    }
}
