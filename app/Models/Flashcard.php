<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;
    public $timestamps = false; 
    protected $table = 'flashcards';
    protected $primaryKey = 'id';

    protected $fillable =
        [
            'word',
            'definition',
            'word_type',
            'pronunciation',
            'example',
            'note',
            'img_url',
            'list_id'

        ];
        public function wordList()
        {
            return $this->belongsTo(ListWord::class, 'list_id');
        }
        
}
