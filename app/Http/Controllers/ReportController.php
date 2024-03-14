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
            ->select('name', 'view', 'users')->get();
        $name = $results[0]->name;
        $view = $results[0]->view;
        $view = json_decode($view);
        $selectedTables = [];
        foreach ($view->tables as $index => $tables) {
            foreach ($tables as $table => $columns) {
                $allcolumns = DB::getSchemaBuilder()->getColumnListing($table);
                $selectedTables[$table] = $allcolumns;
            }
        }
        // dd($selectedTables);
        $selectedUsers = $results[0]->users;
        $selectedUsers = json_decode($selectedUsers);
        $userNames = User::pluck('name')->all();
        // dd($view);
        return view('adminViewCreate.edit', ['view' => $view, 'name' => $name, 'selectedTables' => $selectedTables, 'selectedUsers' => $selectedUsers, 'id' => $id, 'tableNames' => $tableNames, 'users' => $userNames]);
        // dd(implode(', ', array_keys($result['tables'][0])));
    }

    public function editForm(Request $request, $id)
    {
        $users = $request['users'];
        if (empty($request['users'])) {
            $users = [];
        }
        $name = $request['name'];
        $data = $request->except(['_token', 'table', 'users', 'name']);
        if (!isset($data['joins'])) {
            $data['joins'] = [];
        }
        // dd($id);
        // dd($data);
        $updatedData = ['view' => $data, 'name' => $name, 'users' => $users];
        $report = Report::find($id);
        $report->update($updatedData);
        echo "<pre>";

        return redirect('/view-report-list');
        // unset($request['_token']);
        // unset($request['table']);
        // print_r($request->all());
    }
}
