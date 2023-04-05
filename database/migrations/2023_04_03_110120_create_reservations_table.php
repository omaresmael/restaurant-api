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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('table_id')
                ->unsigned()
                ->index('table_reservation_foreign')
                ->nullable();

            $table->Integer('customer_id')
                ->unsigned()
                ->index('customer_reservation_foreign')
                ->nullable();

            $table->dateTime('from_time');
            $table->dateTime('to_time');

            $table->index('from_time');
            $table->index('to_time');

            $table->foreign('table_id')
                ->references('id')
                ->on('tables')
                ->onDelete('Set Null');
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('Set Null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
