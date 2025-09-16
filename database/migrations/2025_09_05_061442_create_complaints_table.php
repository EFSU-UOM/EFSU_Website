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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // link to users table
            $table->string('category'); // canteen, sports, other
            $table->text('complaint_text'); // the complaint content
            $table->boolean('is_anonymous')->default(false);
            $table->json('images')->nullable();
            $table->enum('status', [
                'delivered', 
                'viewed', 
                'in_progress', 
                'action_taken', 
                'rejected', 
                'incomplete'
            ])->default('delivered');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('category');
            $table->index('status');
            $table->index(['status', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
