<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;



return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            DO $$ BEGIN
                CREATE TYPE role_enum AS ENUM ('STUDENT', 'TEACHER', 'ADMIN');
            EXCEPTION
                WHEN duplicate_object THEN NULL;
            END $$;
        ");

        DB::statement("
            DO $$ BEGIN
                CREATE TYPE niveau_enum AS ENUM ('NIVEAU_1', 'NIVEAU_2', 'NIVEAU_3');
            EXCEPTION
                WHEN duplicate_object THEN NULL;
            END $$;
        ");

        DB::statement("
            DO $$ BEGIN
                CREATE TYPE brief_type_enum AS ENUM ('INDIVIDUAL', 'COLLECTIVE');
            EXCEPTION
                WHEN duplicate_object THEN NULL;
            END $$;
        ");

        DB::statement("
            DO $$ BEGIN
                CREATE TYPE evaluation_status_enum AS ENUM ('VALIDEE', 'INVALIDE');
            EXCEPTION
                WHEN duplicate_object THEN NULL;
            END $$;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS evaluation_status_enum");
        DB::statement("DROP TYPE IF EXISTS brief_type_enum");
        DB::statement("DROP TYPE IF EXISTS niveau_enum");
        DB::statement("DROP TYPE IF EXISTS role_enum");
    }
};
