<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('word_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('language', 10)->default('ENG');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('word_lists');
    }
};
