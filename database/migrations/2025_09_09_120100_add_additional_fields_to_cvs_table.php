<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('phone');
            $table->string('address')->nullable()->after('birth_date');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');
            $table->string('linkedin')->nullable()->after('country');
            $table->string('github')->nullable()->after('linkedin');
            $table->string('website')->nullable()->after('github');
            $table->text('summary')->nullable()->after('website');
            $table->string('template')->nullable()->after('summary');
        });
    }

    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'address',
                'city',
                'country',
                'linkedin',
                'github',
                'website',
                'summary',
                'template',
            ]);
        });
    }
};
