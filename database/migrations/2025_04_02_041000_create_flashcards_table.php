<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->text('definition');
            $table->string('word_type')->nullable();
            $table->string('pronunciation')->nullable();
            $table->text('example')->nullable();
            $table->text('note')->nullable();
            $table->text('img_url')->nullable();
            $table->foreignId('list_id')
                ->constrained('word_lists')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};
