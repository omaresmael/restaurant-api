<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared(
            'CREATE TRIGGER `meals_quantity_trigger` AFTER INSERT ON order_details FOR EACH ROW
                BEGIN
                    UPDATE meals SET available_quantity = available_quantity - 1 WHERE id = NEW.meal_id AND available_quantity > 0;
                END'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `meals_quantity_trigger`');
    }
};
