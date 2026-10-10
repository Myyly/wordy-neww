<?php

namespace Database\Factories;

use App\Models\ListWord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flashcard>
 */
class FlashcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'word' => fake()->unique()->word(),
            'definition' => fake()->sentence(),
            'word_type' => fake()->randomElement(['noun', 'verb', 'adjective', 'adverb']),
            'pronunciation' => '/'.fake()->lexify('????').'/',
            'example' => fake()->sentence(),
            'note' => null,
            'img_url' => null,
            'list_id' => ListWord::factory(),
        ];
    }
}
