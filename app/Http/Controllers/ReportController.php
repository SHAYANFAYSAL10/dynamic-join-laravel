<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use DB;

class ReportController extends Controller
{
    protected function generateSqlQuery($data, $duplicateKeys)
    {
        $selectColumns = [];
        $tableNames = [];
        foreach ($data['tables'] as $indexes => $tables) {
            foreach ($tables as $tablename => $columns) {
                $tableNames[] = $tablename;
                foreach ($columns as $column) {
                    $selectColumns[] = in_array($column, $duplicateKeys) != 0 ? "$tablename.$column as {$tablename}_{$column}" : "$tablename.$column";
                }
            }
        }
        $selectColumns = implode(', ', $selectColumns);
        $numberOfIteration = 1;
        $joinClauses = '';
        $tableAlias = $tableNames[0];
        $joinClauses .= $tableAlias . " ";
        foreach ($data['joins'] as $join) {
            $joinClauses .= "{$join['join_type']} JOIN {$tableNames[$numberOfIteration]}";
            $onCommand = $join['join_type'] !== 'cross' ? " ON {$join['left_table']}.{$join['left_column']} = {$join['right_table']}.{$join['right_column']} " : " ";
            $joinClauses .= $onCommand;
            $numberOfIteration++;
        }

        return "SELECT $selectColumns FROM $joinClauses";
    }


    protected function duplicateKeys($data)
    {
        $duplicateKeys = [];
        $encounteredKeys = [];
        foreach ($data['tables'] as $indexes => $tables) {
            foreach ($tables as $tablename => $columns) {
                foreach ($columns as $column) {
                    if (in_array($column, $encounteredKeys)) {
                        $duplicateKeys[] = $column;
                    } else {
                        $encounteredKeys[] = $column;
                    }
                }
            }
        }
        return $duplicateKeys;
    }

    public function showData($id)
    {
        $report = Report::find($id);
        $data = $report->view;
        $name = $report->name;
        $duplicateKeys = $this->duplicateKeys($data);
        $result = $this->generateSqlQuery($data, $duplicateKeys);
        $result = DB::select($result);
        return view('viewReport.index', ['data' => $result, 'name' => $name]);
    }

    public function destroy($id)
    {
        Report::destroy($id);
        return redirect('/view-report-list')->with('flash_message', 'Report deleted!');
    }

    public function edit($id)
    {
        $tableNames = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tableNames);
        $results = DB::table('reports')
            ->where('id', $id)
            ->value('view');
        $results = json_decode($results, true);
        $userNames = User::pluck('name')->all();
        // dd($result->tables);
        return view('adminViewCreate.edit', ['results' => $results, 'id' => $id, 'tableNames' => $tableNames, 'users' => $userNames]);
        // dd(implode(', ', array_keys($result['tables'][0])));
    }
}
