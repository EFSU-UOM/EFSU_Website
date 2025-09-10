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
        Schema::table('complaints', function (Blueprint $table) {
            $table->boolean('is_anonymous')->default(false);
            $table->json('images')->nullable();
        });
        
        // For PostgreSQL compatibility, drop and recreate the status column
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('complaints', function (Blueprint $table) {
            $table->enum('status', [
                'delivered', 
                'viewed', 
                'in_progress', 
                'action_taken', 
                'rejected', 
                'incomplete'
            ])->default('delivered');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['is_anonymous', 'images']);
        });
        
        // For PostgreSQL compatibility, drop and recreate the status column
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('complaints', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'in_progress', 
                'resolved',
                'closed'
            ])->default('pending');
        });
    }
};
