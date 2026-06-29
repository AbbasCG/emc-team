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
        Schema::create('volunteer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('job_description_id')->nullable()->constrained('job_descriptions')->nullOnDelete();
            $table->unsignedInteger('required_volunteers')->default(1);
            $table->enum('status', ['draft', 'open', 'closed', 'cancelled'])->default('draft');
            $table->date('deadline')->nullable();
            $table->json('requirements')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_requests');
    }
};
