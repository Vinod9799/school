<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bus_id');
            $table->enum('fuel_type', ['petrol', 'diesel']);
            $table->decimal('amount_litre', 8, 2);
            $table->decimal('total_cost', 10, 2);
            $table->date('fill_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuel_expenses');
    }
}
