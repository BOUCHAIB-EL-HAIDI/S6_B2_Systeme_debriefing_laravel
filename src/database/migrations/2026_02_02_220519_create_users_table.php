<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->string('password');


            $table->enum('role', ['STUDENT','TEACHER','ADMIN']);

            $table->foreignId('classe_id')
                  ->nullable()
                  ->constrained('classes')
                  ->nullOnDelete();

            $table->timestamps();
        });

        // ✅ CHECK constraint (role ↔ classe rule)
        DB::statement("
            ALTER TABLE users ADD CONSTRAINT chk_role_classe CHECK (
                (role = 'ADMIN' AND classe_id IS NULL)
                OR
                (role IN ('STUDENT','TEACHER') AND classe_id IS NOT NULL)
            )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
