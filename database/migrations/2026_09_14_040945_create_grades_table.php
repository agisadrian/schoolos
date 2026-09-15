<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_id')
                ->constrained('school_classes')
                ->cascadeOnDelete();

            $table->foreignId('subject_id')
                ->constrained('subjects')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('entered_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title');

            $table->decimal('score', 5, 2);

            $table->decimal('max_score', 5, 2)
                ->default(100);

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'class_id',
                'subject_id',
                'student_id',
                'title'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};