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
       Schema::create('competence_debriefing', function (Blueprint $table) {
       $table->foreignId('debriefing_id')->constrained('debriefings')->cascadeOnDelete();
       $table->string('competence_code', 20)
             ->constrained('competences')->cascadeOnDelete();
        $table->enum('niveau', ['NIVEAU_1','NIVEAU_2','NIVEAU_3']);
        $table->enum('status', ['VALIDEE','INVALIDE']);
        $table->primary(['debriefing_id','competence_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competence_debriefing');
    }
};
