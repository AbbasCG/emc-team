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
        Schema::create('job_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->json('requirements')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('skills')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('max_volunteers')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_descriptions');
    }
};
