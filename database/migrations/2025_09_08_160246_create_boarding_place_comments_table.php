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
        Schema::create('boarding_place_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('boarding_place_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('boarding_place_comments')->onDelete('cascade');
            $table->text('content');
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('score')->default(0);
            $table->integer('depth')->default(0);
            $table->timestamps();

            $table->index(['boarding_place_id', 'parent_id']);
            $table->index(['boarding_place_id', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boarding_place_comments');
    }
};
