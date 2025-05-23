<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListWord extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $table = 'word_lists';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'title',
            'language',
            'description',
            'user_id'

        ];
        public function flashcards()
        {
            return $this->hasMany(Flashcard::class, 'list_id');
        }
        public function countFlashcards($id)
{
    $wordList = ListWord::find($id);
    if (!$wordList) {
        return response()->json(['message' => 'Word List not found'], 404);
    }
    return $wordList->flashcards()->count();
}
}
