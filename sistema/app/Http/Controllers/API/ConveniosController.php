<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConveniosController extends Controller
{
    public function index()
    {        
        $arquivo = file_get_contents('../resources/json/convenios.json');

        return $arquivo;
    }

}
