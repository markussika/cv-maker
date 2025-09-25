<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            if (!Schema::hasColumn('cvs', 'headline')) {
                $table->string('headline')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('cvs', 'summary')) {
                $table->text('summary')->nullable()->after('headline');
            }

            if (!Schema::hasColumn('cvs', 'website')) {
                $table->string('website')->nullable()->after('summary');
            }

            if (!Schema::hasColumn('cvs', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('website');
            }

            if (!Schema::hasColumn('cvs', 'github')) {
                $table->string('github')->nullable()->after('linkedin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            foreach (['github', 'linkedin', 'website', 'summary', 'headline'] as $column) {
                if (Schema::hasColumn('cvs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
