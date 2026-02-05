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
        Schema::create('livrables', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->text('comment');
            $table->timestamp('submitted_at')->useCurrent();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('brief_id')->constrained('briefs')->cascadeOnDelete();
            $table->unique(['student_id','brief_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livrables');
    }
};
