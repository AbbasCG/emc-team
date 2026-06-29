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
        Schema::table('job_descriptions', function (Blueprint $table) {
            $table->string('direct_supervisor')->nullable()->after('title_ar');
            $table->enum('work_location', ['remote', 'onsite', 'hybrid'])->default('onsite')->after('direct_supervisor');
            $table->text('general_objective')->nullable()->after('work_location');
            $table->text('task_1')->nullable()->after('general_objective');
            $table->text('task_2')->nullable()->after('task_1');
            $table->text('task_3')->nullable()->after('task_2');
            $table->text('task_4')->nullable()->after('task_3');
            $table->string('education_requirements')->nullable()->after('task_4');
            $table->string('years_experience')->nullable()->after('education_requirements');
            $table->string('certifications')->nullable()->after('years_experience');
            $table->text('hard_skills')->nullable()->after('certifications');
            $table->text('soft_skills')->nullable()->after('hard_skills');
            $table->string('languages')->nullable()->after('soft_skills');
            $table->enum('jd_status', ['active', 'draft', 'archived'])->default('active')->after('languages');
        });
    }

    public function down(): void
    {
        Schema::table('job_descriptions', function (Blueprint $table) {
            $table->dropColumn([
                'direct_supervisor', 'work_location', 'general_objective',
                'task_1', 'task_2', 'task_3', 'task_4',
                'education_requirements', 'years_experience', 'certifications',
                'hard_skills', 'soft_skills', 'languages', 'jd_status',
            ]);
        });
    }
};
