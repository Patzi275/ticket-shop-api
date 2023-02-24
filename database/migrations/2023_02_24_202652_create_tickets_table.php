<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ticket (id, nom, prix, description, date_limite, change_prix, change_date, #evenement_id)
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('prix', 8, 2);
            $table->text('description');
            $table->dateTime('date_limite');
            $table->decimal('change_prix', 8, 2)->nullable();
            $table->dateTime('change_date')->nullable();
            $table->foreignId('evenement_id')->constrained();
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
        Schema::dropIfExists('tickets');
    }
}
