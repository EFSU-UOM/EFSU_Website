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
        Schema::create('boarding_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->json('images')->nullable(); // Store multiple image paths
            $table->string('location');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('distance_to_university', 8, 2)->nullable(); // Distance in km
            $table->decimal('price', 10, 2)->nullable(); // Price if available
            $table->string('price_period')->nullable(); // per month, per semester, etc.
            $table->integer('capacity')->nullable(); // Number of students that can be accommodated
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('distance_to_university');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_places');
    }
};
