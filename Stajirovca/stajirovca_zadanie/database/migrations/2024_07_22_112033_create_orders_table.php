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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('products')->nullable();
            $table->decimal('total',8,2);
            $table->unsignedBigInteger('status_id',);
            $table->unsignedBigInteger('payment_type_id',);
            $table->unsignedBigInteger('receiving_type_id',);
            $table->string('phone',);
            $table->string('email',);
            $table->string('FIO');
            $table->string('address')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('receiving_type_id')->references('id')->on('receiving_types');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
