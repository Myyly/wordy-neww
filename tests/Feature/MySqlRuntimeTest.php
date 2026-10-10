<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use App\Models\ListWord;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MySqlRuntimeTest extends TestCase
{
    private bool $transactionStarted = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (DB::getDriverName() !== 'mysql') {
            $this->markTestSkipped('This test only runs against the restored MySQL database.');
        }

        DB::beginTransaction();
        $this->transactionStarted = true;
    }

    protected function tearDown(): void
    {
        if ($this->transactionStarted) {
            DB::rollBack();
        }

        parent::tearDown();
    }

    public function test_restored_mysql_schema_seed_and_main_flows(): void
    {
        $database = DB::getDatabaseName();

        $definitionType = DB::table('information_schema.columns')
            ->where('table_schema', $database)
            ->where('table_name', 'flashcards')
            ->where('column_name', 'definition')
            ->value('data_type');

        $wordListDeleteRule = DB::table('information_schema.referential_constraints')
            ->where('constraint_schema', $database)
            ->where('table_name', 'word_lists')
            ->value('delete_rule');

        $flashcardDeleteRule = DB::table('information_schema.referential_constraints')
            ->where('constraint_schema', $database)
            ->where('table_name', 'flashcards')
            ->value('delete_rule');

        $this->assertSame('text', $definitionType);
        $this->assertContains($wordListDeleteRule, ['RESTRICT', 'NO ACTION']);
        $this->assertSame('CASCADE', $flashcardDeleteRule);
        $this->assertDatabaseHas('users', ['email' => 'demo@wordy.local']);
        $this->assertDatabaseCount('word_lists', 2);
        $this->assertDatabaseCount('flashcards', 10);
        $this->assertTrue(Hash::check('password', User::where('email', 'demo@wordy.local')->value('password')));

        Notification::fake();

        $this->post('/register', [
            'full_name' => 'MySQL Registered User',
            'email' => 'mysql-register@wordy.local',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('login'));

        $registeredUser = User::where('email', 'mysql-register@wordy.local')->firstOrFail();
        Notification::assertSentTo($registeredUser, VerifyEmail::class);

        $user = User::factory()->create([
            'email' => 'mysql-runtime@wordy.local',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('list-word'));

        $this->actingAs($user)
            ->post('/profile/edit-info', [
                'fullName' => 'MySQL Runtime User',
                'bio' => 'Profile saved in MySQL.',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'full_name' => 'MySQL Runtime User',
            'bio' => 'Profile saved in MySQL.',
        ]);

        $this->actingAs($user)
            ->post('/list_word/add', [
                'title' => 'MySQL Runtime List',
                'description' => 'Temporary transactional test data',
            ])
            ->assertRedirect(route('list-word'));

        $list = ListWord::where('user_id', $user->id)->firstOrFail();

        $this->actingAs($user)
            ->post('/flashcard/add', [
                'word' => 'mysql',
                'definition' => str_repeat('Long definition. ', 40),
                'word_type' => 'noun',
                'id_list' => $list->id,
            ])
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $flashcard = Flashcard::where('list_id', $list->id)->firstOrFail();

        $this->actingAs($user)
            ->post('/flashcard/adds', [
                'word' => ['bulk-one', 'bulk-two'],
                'definition' => ['First bulk definition', 'Second bulk definition'],
                'pronunciation' => [null, null],
                'word_type' => ['noun', 'noun'],
                'example1' => ['First example', 'Second example'],
                'example2' => ['', ''],
                'id_list_words' => $list->id,
            ])
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $this->assertDatabaseCount('flashcards', 13);

        $this->actingAs($user)
            ->post('/flashcard/edit/'.$flashcard->id, [
                'word' => 'mysql-edited',
                'definition' => 'Edited MySQL definition',
                'word_type' => 'noun',
                'pronunciaton' => '/mysql/',
            ])
            ->assertRedirect(route('index', ['list_id' => $list->id]));

        $this->actingAs($user)
            ->get('/flashcard/search?list_id='.$list->id.'&search=mysql-edited')
            ->assertOk()
            ->assertSee('mysql-edited');

        $this->post('/password/email', ['email' => $user->email])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);
        Notification::assertSentTo($user, ResetPassword::class);

        $list->delete();

        $this->assertDatabaseMissing('flashcards', ['id' => $flashcard->id]);
    }
}
