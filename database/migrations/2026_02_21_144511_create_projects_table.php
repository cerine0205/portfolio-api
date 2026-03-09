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
            $table->unsignedInteger('team_size')->default(1);

            $table->json('tech_stack')->nullable();
            $table->string('image')->nullable();

            $table->text('problem')->nullable();
            $table->text('solution')->nullable();

            $table->string('github_url')->nullable();   
            $table->string('live_url')->nullable();     
            $table->string('report_url')->nullable();  
            $table->string('demo_url')->nullable();
            $table->string('presentation_url')->nullable();

            $table->string('role')->nullable();        
            $table->string('duration')->nullable();    
            $table->string('type')->nullable();        

            $table->text('challenges')->nullable();    
            $table->text('results')->nullable();  
            
            $table->json('features')->nullable();

            $table->text('architecture')->nullable();
            $table->string('architecture_image')->nullable();

            $table->text('refactor_notes')->nullable();

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