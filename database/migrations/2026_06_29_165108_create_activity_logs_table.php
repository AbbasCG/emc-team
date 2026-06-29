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
        // Intentionally empty — activity logging is handled by spatie/laravel-activitylog,
        // which publishes and manages its own migration for the activity_log table.
    }

    public function down(): void
    {
        // Nothing to reverse.
    }
};
