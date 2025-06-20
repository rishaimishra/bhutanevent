<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('author_questions', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('question');
        });
    }

    public function down(): void
    {
        Schema::table('author_questions', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
    }
}; 