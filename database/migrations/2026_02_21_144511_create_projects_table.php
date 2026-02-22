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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->year('year');
            $table->boolean('featured')->default(false);
            $table->string('status')->default('draft');
            $table->integer('team_size')->default(1);

            $table->json('tags')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('image')->nullable();
            $table->json('screenshots')->nullable();

            $table->text('problem')->nullable();
            $table->text('solution')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
