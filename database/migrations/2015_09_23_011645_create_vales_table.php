<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vales', function (Blueprint $table) {
            $table->increments('id_vale');
            $table->string('serie');
            $table->integer('folio');
            $table->integer('id_distribuidor');
            $table->integer('id_cliente');
            $table->integer('id_cuenta'); 
            $table->date('fecha_venta');
            $table->integer('cantidad');
            $table->integer('cantidad_limite');
            $table->date('fecha_creacion');     
            $table->integer('numero_pagos');    
            $table->integer('folio_venta'); 
            $table->integer('pagos_realizados');
            $table->text('motivo_cancelación');
            $table->integer('deuda_actual');   
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
        Schema::drop('vales');
    }
}
