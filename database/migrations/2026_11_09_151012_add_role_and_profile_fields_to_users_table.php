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
            $table->string('role', 20)->default('participant')->after('email');
            $table->string('phone', 30)->nullable()->after('role');
            $table->string('organization_name')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('organization_name');
            $table->string('avatar_path')->nullable()->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'organization_name', 'bio', 'avatar_path']);
        });
    }
};
