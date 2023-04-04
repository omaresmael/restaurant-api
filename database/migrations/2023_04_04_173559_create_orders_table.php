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

            $table->unsignedBigInteger('reservation_id')
                ->index('reservation_order_foreign')
                ->nullable();

            $table->smallInteger('waiter_id')
                ->unsigned()
                ->index('waiter_order_foreign')
                ->nullable();

            $table->decimal('total')->nullable();
            $table->decimal('paid')->nullable();
            $table->dateTime('paid_at')->nullable();

            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->onDelete('Set Null');

            $table->timestamps();
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
