<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Evenement (id, titre, date, lieu, description, contact, #organisation_id, #categorie_id)

        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->unique();
            $table->dateTime('date');
            $table->string('lieu');
            $table->text('description');
            $table->string('contact');
            $table->foreignId('organisateur_id')->nullable()->constrained();
            $table->foreignId('categorie_id')->nullable()->constrained();
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
        Schema::dropIfExists('evenements');
    }
}
