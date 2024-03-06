<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class jsonjoin extends Controller
{
    public function index()
    {
        $tableNames = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tableNames);
        return view('jsonjoin.index',"hello");
    }
}
