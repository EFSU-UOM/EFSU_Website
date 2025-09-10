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
            $table->enum('status', [
                'delivered', 
                'viewed', 
                'in_progress', 
                'action_taken', 
                'rejected', 
                'incomplete'
            ])->default('delivered')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['is_anonymous', 'images']);
            $table->enum('status', [
                'pending',
                'in_progress', 
                'resolved',
                'closed'
            ])->default('pending')->change();
        });
    }
};
