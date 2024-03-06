<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use DB;

class JoinController extends Controller
{
    public function index()
    {
        $tableNames = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tableNames);
        return view('adminViewCreate.index', ['tableNames' => $tableNames]);
    }

    public function fetch(Request $request)
    {
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::getSchemaBuilder()->getColumnListing($value);
        return response()->json([
            'data' => $data,
            'dependent' => $dependent,
            'message' => 'Data retrieved successfully',
        ]);
    }

    public function fetch_datas(Request $request)
    {
        $tableName = $request->get('tableName');
        // $select=$request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table($tableName)->select($value)->get();
        return response()->json([
            'data' => $data,
            'dependent' => $dependent,
            'message' => 'Data retrieved successfully',
        ]);
    }

    public function fetch_join_datas(Request $request)
    {
        $leftTable = $request->get('leftTable');
        $rightTable = $request->get('rightTable');
        $leftTableColumns = $request->get('leftTableColumns');
        $rightTableColumns = $request->get('rightTableColumns');
        $joinType = $request->get('joinType');
        $leftMatchingColumn = $request->get('leftMatchingColumn');
        $rightMatchingColumn = $request->get('rightMatchingColumn');

        $totalColumns = count($leftTableColumns) + count($rightTableColumns);
        $currentColumnIndex = 0;
        $columnNames = "";
        $sql = "select ";

        foreach ($leftTableColumns as $leftTableColumn) {
            $currentColumnIndex++;
            $columnNames .= ("l." . $leftTableColumn . " as " . $leftTable . "_" . $leftTableColumn);
            if ($currentColumnIndex != $totalColumns) {
                $columnNames .= (",");
            }
        }
        foreach ($rightTableColumns as $rightTableColumn) {
            $currentColumnIndex++;
            $columnNames .= ("r." . $rightTableColumn . " as " . $rightTable . "_" . $rightTableColumn);
            if ($currentColumnIndex != $totalColumns) {
                $columnNames .= (",");
            }
        }
        $sql .= ($columnNames . " from " . $leftTable . " l " . $joinType . " join " . $rightTable . " r");
        if ($joinType !== 'cross') {
            $sql .= (" on l." . $leftMatchingColumn . "=r." . $rightMatchingColumn);
        }
        $data = DB::select($sql);

        return response()->json([
            'data' => $data,
            'message' => 'Data retrieved successfully',
        ]);
    }

    public function processForm(Request $request)
    {
        $data = $request->except(['_token', 'table']);
        if (!isset($data['joins'])) {
            $data['joins'] = [];
        }
        // dd($data);

        Report::create(['view' => $data]);
        echo "<pre>";

        return redirect()->route('adminViewCreate.index');
        // unset($request['_token']);
        // unset($request['table']);
        // print_r($request->all());
    }
}
