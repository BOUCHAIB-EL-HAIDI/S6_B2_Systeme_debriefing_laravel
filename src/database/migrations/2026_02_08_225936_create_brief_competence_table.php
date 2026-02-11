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
        if (!Schema::hasTable('brief_competence')) {
            Schema::create('brief_competence', function (Blueprint $table) {
                $table->foreignId('brief_id')->constrained('briefs')->cascadeOnDelete();
                $table->string('competence_code', 20);
                $table->foreign('competence_code')->references('code')->on('competences')->cascadeOnDelete();
                $table->primary(['brief_id', 'competence_code']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brief_competence');
    }
};
