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
        Schema::create('meals', function (Blueprint $table) {
            $table->smallInteger('id')
                ->unsigned()
                ->autoIncrement();
            $table->string('name', 50);
            $table->string('description', 2000);
            $table->smallInteger('available_quantity')
                ->default(0)
                ->unsigned();
            $table->smallInteger('initial_quantity')
                ->unsigned();
            $table->decimal('price',6);
            $table->float('discount',4)
                ->default(0)
                ->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
