<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistribuidorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribuidors', function (Blueprint $table) {
            $table->increments('id_distribuidor');
            $table->string('nombre');
            $table->string('calle');
            $table->integer('numero_exterior');
            $table->integer('numero_interior');
            $table->string('colonia');
            $table->string('municipio');
            $table->string('estado');
            $table->integer('codigo_postal');
            $table->string('telefono');
            $table->string('celular');
            $table->string('foto'); 
            $table->string('firma');
            $table->integer('limite_credito');
            $table->integer('limite_vale');
            $table->integer('comision');     
            $table->integer('saldo_actual');    
            $table->string('nombre_aval'); 
            $table->text('dirección_aval');
            $table->string('telefono_aval');
            $table->string('celular_aval');   
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
        Schema::drop('distribuidors');
    }
}
