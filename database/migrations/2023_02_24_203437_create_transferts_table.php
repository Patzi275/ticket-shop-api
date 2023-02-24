<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Transfert (id, somme, date, est_confirme, #organisateur_id)
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->decimal('somme', 8, 2);
            $table->dateTime('date');
            $table->boolean('est_confirmer')->default(false);
            $table->foreignId('organisateur_id')->constrained();
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
        Schema::dropIfExists('transferts');
    }
}
