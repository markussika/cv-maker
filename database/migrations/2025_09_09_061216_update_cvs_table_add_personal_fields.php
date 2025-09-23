<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            if (!Schema::hasColumn('cvs', 'birthday')) {
                $table->date('birthday')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('cvs', 'country')) {
                $table->string('country')->nullable()->after('birthday');
            }
            if (!Schema::hasColumn('cvs', 'city')) {
                $table->string('city')->nullable()->after('country');
            }
            if (!Schema::hasColumn('cvs', 'template')) {
                $table->string('template')->nullable()->after('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            if (Schema::hasColumn('cvs', 'template')) {
                $table->dropColumn('template');
            }
            if (Schema::hasColumn('cvs', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('cvs', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('cvs', 'birthday')) {
                $table->dropColumn('birthday');
            }
        });
    }
};
