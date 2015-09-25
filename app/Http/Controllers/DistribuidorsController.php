<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DistribuidorsController extends Controller
{
    


    public function crearDistribuidor()
    {
        return view('distribuidor.crearDistribuidor');
    }

 
    public function guardarDistribuidor(Request $request)
    {
        //
    }

    public function verDistribuidor($id)
    {
        //
    }

    public function editarDistribuidor($id)
    {
        //
    }

  
    public function actualizarDistribuidor(Request $request, $id)
    {
        //
    }

}
