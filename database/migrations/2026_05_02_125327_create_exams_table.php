<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')
                    ->constrained('classroom')
                    ->cascadeOnDelete();
            $table->foreignId('subject_id')
                    ->constrained('subject')
                    ->cascadeOnDelete();
            $table->foreignId('created_by')
                    ->constrained('users')
                    ->cascadeOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->integer('duration');
            $table->enum('visibility', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
