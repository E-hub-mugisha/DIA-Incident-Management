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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('likelihood', ['Low', 'Medium', 'High']);
            $table->enum('impact', ['Low', 'Medium', 'High']);
            $table->string('level')->nullable(); // e.g. 'Low', 'Medium', 'High', 'Critical'
            $table->enum('status', ['Pending', 'In Progress', 'Mitigated', 'Escalated'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
