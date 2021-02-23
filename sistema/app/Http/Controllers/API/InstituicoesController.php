<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstituicoesController extends Controller
{
    
    public function index()
    {
        $arquivo = file_get_contents('../resources/json/instituicoes.json');

        return $arquivo;
    }
    

}
