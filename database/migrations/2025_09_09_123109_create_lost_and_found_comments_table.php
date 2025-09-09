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
        Schema::create('lost_and_found_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lost_and_found_id')->constrained('lost_and_found')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('lost_and_found_comments')->onDelete('cascade');
            $table->text('content');
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('score')->default(0);
            $table->integer('depth')->default(0); // for easier querying of nested levels
            $table->timestamps();

            $table->index(['lost_and_found_id', 'parent_id']);
            $table->index(['lost_and_found_id', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_and_found_comments');
    }
};
