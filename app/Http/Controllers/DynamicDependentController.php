<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DynamicDependentController extends Controller
{
    public function index()
    {
        $tableNames = DB::table('table_info')->select('tablename')->groupBy('tablename')->get();
        return view('dynamicInfoViewer.index',['tableNames'=>$tableNames]);
    }

    public function fetch(Request $request)
    {
        $select=$request->get('select');
        $value=$request->get('value');
        $dependent=$request->get('dependent');
        $data=DB::table('table_info')->where($select,$value)->get();
        // $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        $output='';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }

    public function fetch_datas(Request $request)
    {
        $tableName=$request->get('tableName');
        $select=$request->get('select');
        $value=$request->get('value');
        $dependent=$request->get('dependent');
        $data=DB::table($tableName)->select($select)->get();
        // $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        // $output='';
        // foreach($data as $row)
        // {
        //     $output .= '<td>'.$row->$dependent.'</td>';
        // }
        // echo $output;
        return response()->json([
            'data' => $data,
            'message' => 'Data retrieved successfully',
        ]);
    }
}
