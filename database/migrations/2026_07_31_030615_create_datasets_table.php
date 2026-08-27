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
        Schema::create('datasets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('description');
            $table->foreignId('category_data_id')->constrained('category_data')->cascadeOnDelete();
            $table->foreignId('periode_data_id')->nullable()->constrained('periode_data')->cascadeOnDelete();
            $table->foreignId('type_data_id')->constrained('type_data')->cascadeOnDelete();
            $table->longText('file')->nullable();
            $table->foreignId('upload_by')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['draft', 'published', 'verified', 'approved', 'rejected', 'reviewed'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};
