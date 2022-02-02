<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dummyAPI extends Controller
{
    function getdata(){
        return ["name" =>"Monir Hossain", "age"=>28, "address"=>"Narayanganj"];
    }
}
