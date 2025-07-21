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
        Schema::create('mitigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->text('strategy');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->date('deadline')->nullable();
            $table->enum('status', ['Not Started', 'In Progress', 'Completed'])->default('Not Started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitigations');
    }
};
