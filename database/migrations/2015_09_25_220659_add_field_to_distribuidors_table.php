<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToDistribuidorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribuidors', function (Blueprint $table) {
            //
            

            $table->string('calle_aval');
            $table->integer('numero_exterior_aval');
            $table->integer('numero_interior_aval');
            $table->string('colonia_aval');
            $table->string('municipio_aval');
            $table->string('estado_aval');
            $table->integer('codigo_postal_aval');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribuidors', function (Blueprint $table) {
            //
        });
    }
}
