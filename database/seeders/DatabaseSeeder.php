<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use App\Models\ListWord;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(['email' => 'demo@wordy.local'], [
            'full_name' => 'Wordy Demo',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar_img' => 'avatars/avatar_26.jpg',
            'cover_img' => 'covers/cover_26.jpg',
            'bio' => 'Tài khoản mẫu dùng để kiểm thử Wordy.',
            'is_verified' => true,
        ]);

        $dailyWords = ListWord::updateOrCreate([
            'user_id' => $user->id,
            'title' => 'Daily English',
        ], [
            'language' => 'ENG',
            'description' => 'Từ vựng tiếng Anh sử dụng hằng ngày.',
        ]);

        $interviewWords = ListWord::updateOrCreate([
            'user_id' => $user->id,
            'title' => 'Job Interview',
        ], [
            'language' => 'ENG',
            'description' => 'Từ vựng dùng trong phỏng vấn công việc.',
        ]);

        foreach ([$dailyWords, $interviewWords] as $wordList) {
            $missingFlashcards = max(0, 5 - $wordList->flashcards()->count());
            Flashcard::factory()->count($missingFlashcards)->create(['list_id' => $wordList->id]);
        }
    }
}
