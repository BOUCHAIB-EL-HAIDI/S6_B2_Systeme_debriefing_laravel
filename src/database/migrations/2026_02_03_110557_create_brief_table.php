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
        Schema::create('brief', function (Blueprint $table) {
         $table->id();
         $table->string('title', 150);
         $table->text('content')->nullable();
         $table->date('start_date');
         $table->date('end_date');
         $table->enum('type', ['INDIVIDUAL','COLLECTIVE']);
         $table->boolean('is_assigned')->default(false);
         $table->foreignId('sprint_id')->constrained('sprint')->cascadeOnDelete();
         $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
         $table->timestamp('created_at')->useCurrent();
        });
        DB::statement("
        ALTER TABLE brief ADD CONSTRAINT chk_dates CHECK (end_date >= start_date)
         ");


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brief');
    }
};
