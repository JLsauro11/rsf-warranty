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
        Schema::create('product_name', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Ensure InnoDB
            $table->id();
            $table->unsignedBigInteger('product_id');           // FK column
            $table->string('model_code', 50);
            $table->string('model_label', 100);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_name');
    }
};
