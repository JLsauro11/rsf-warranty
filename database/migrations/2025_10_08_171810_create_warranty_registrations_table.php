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
        Schema::create('warranty_registrations', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Ensure InnoDB
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('contact_no', 20);
            // Remove enum 'product' to avoid conflict with FK
            $table->unsignedBigInteger('product_id');          // FK column
            $table->unsignedBigInteger('product_name_id');     // FK column
            $table->string('serial_no', 100);
            $table->date('purchase_date');
            $table->string('receipt_no', 100);
            $table->string('product_image_path')->nullable();
            $table->string('receipt_image_path')->nullable();
            $table->string('store_name', 150)->nullable();
            $table->string('facebook_account_link', 255)->nullable();
            $table->enum('status', ['pending', 'approved', 'disapproved'])->default('pending');

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('product')->onDelete('restrict');
            $table->foreign('product_name_id')->references('id')->on('product_name')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_registrations');
    }
};
