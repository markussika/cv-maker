<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('profile_image')->nullable();

            $table->json('hobbies')->nullable();
            $table->json('languages')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('education')->nullable();
            $table->json('skills')->nullable();
            $table->json('extra_curriculum_activities')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cvs');
    }
};
