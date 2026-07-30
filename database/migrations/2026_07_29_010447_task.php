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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained('projects', 'id')->onDelete('cascade');
            $table->string('title');
            $table->string('description');
            $table->enum('status', ['todo', 'in_progress', 'done,']);
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->dateTime('due_date');
            $table->boolean('deleted')->default(false);
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tasks');
    }
};
