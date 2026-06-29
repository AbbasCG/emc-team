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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin', 'volunteer', 'guest'])->default('guest')->after('email');
            $table->enum('status', ['active', 'inactive', 'suspended', 'pending'])->default('pending')->after('role');
            $table->string('phone')->nullable()->after('status');
            $table->string('phone_country_code', 10)->default('+966')->after('phone');
            $table->string('country_code', 5)->default('SA')->after('phone_country_code');
            $table->string('city')->nullable()->after('country_code');
            $table->enum('gender', ['male', 'female'])->nullable()->after('city');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('avatar')->nullable()->after('date_of_birth');
            $table->string('national_id')->nullable()->after('avatar');
            $table->string('how_did_you_hear_about_us')->nullable()->after('national_id');
            $table->text('bio')->nullable()->after('how_did_you_hear_about_us');
            $table->timestamp('last_login_at')->nullable()->after('bio');
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete()->after('last_login_at');
            $table->unsignedBigInteger('job_description_id')->nullable()->after('department_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
            $table->dropColumn('job_description_id');
            $table->dropColumn([
                'role', 'status', 'phone', 'phone_country_code', 'country_code',
                'city', 'gender', 'date_of_birth', 'avatar', 'national_id',
                'how_did_you_hear_about_us', 'bio', 'last_login_at',
            ]);
        });
    }
};
