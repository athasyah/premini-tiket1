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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama fee
            $table->enum('type', ['fixed', 'percent']); // Jenis fee
            $table->decimal('amount', 10, 2)->nullable(); // Nilai fee tetap
            $table->decimal('percentage', 5, 2)->nullable(); // Nilai fee dalam persen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
