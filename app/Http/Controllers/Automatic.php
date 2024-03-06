<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;

class Automatic extends Controller
{
    public function getTableNames()
    {
        $tableNames = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tableNames);
        return $tableNames;
    }

    public function index()
    {
        // $response = Http::timeout(1500)->get('http://localhost:8000/api/automatic/tablenames');
        // $response = Http::get('api/automatic/tablenames');
        // $data = $response->json();

        // return view('your-view', ['apiData' => $data]);
        $tableNames = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tableNames);
        // return $tableNames;
        return view('automatic.index',['tableNames'=>$tableNames]);
    }

    public function fetch(Request $request)
    {
        $value=$request->get('value');
        $dependent=$request->get('dependent');
        $data = DB::getSchemaBuilder()->getColumnListing($value);
        return response()->json([
            'data' => $data,
            'message' => 'Data retrieved successfully',
        ]);
    }

    public function fetch_datas(Request $request)
    {
        $tableName=$request->get('tableName');
        $select=$request->get('select');
        $value=$request->get('value');
        $dependent=$request->get('dependent');
        $data=DB::table($tableName)->select($select)->get();
        return response()->json([
            'data' => $data,
            'message' => 'Data retrieved successfully',
        ]);
    }
}
