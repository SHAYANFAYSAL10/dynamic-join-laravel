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
        $emptyMap = [];
        $aliasofTables = [];
        $tableNames = [];
        $currentItr = 0;
        foreach ($data['tables'] as $indexes => $tables) {
            foreach ($tables as $tablename => $columns) {
                $tableNames[] = $tablename;
                if (isset($emptyMap[$tablename])) {
                    $emptyMap[$tablename]['count']++;
                } else {
                    $emptyMap[$tablename]['count'] = 1; // Initialize value to 1
                }
                $tempAlias = '';
                for ($i = 0; $i < $emptyMap[$tablename]['count']; $i++) {
                    $tempAlias .= $tablename;
                }
                $aliasofTables[] = $tempAlias;
                foreach ($columns as $column) {
                    if (isset($emptyMap[$tablename][$column])) {
                        $emptyMap[$tablename][$column]++;
                    } else {
                        $selectColumns[] = in_array($column, $duplicateKeys) != 0 ? "$aliasofTables[$currentItr].$column as {$tablename}_{$column}" : "$tablename.$column";
                        $emptyMap[$tablename][$column] = 1;
                    }
                }
            }
            $currentItr++;
        }
        // dd($emptyMap);
        $selectColumns = implode(', ', $selectColumns);
        $numberOfIteration = 1;
        $joinClauses = '';
        $tableAlias = $tableNames[0];
        $joinClauses .= $tableAlias . " ";
        foreach ($data['joins'] as $join) {
            $joinClauses .= "{$join['join_type']} JOIN {$tableNames[$numberOfIteration]} {$aliasofTables[$numberOfIteration]}";
            $onCommand = $join['join_type'] !== 'cross' ? " ON {$join['left_table']}.{$join['left_column']} = {$join['right_table']}.{$join['right_column']} " : " ";
            $joinClauses .= $onCommand;
            $numberOfIteration++;
        }
        // dd($joinClauses);

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

    public function showData($id, $startDate = null, $endDate = null)
    {
        if ($startDate === null && $endDate === null) {
            $endDate = date("Y-m-d");
            $startDate = date("Y-m-d", strtotime("-6 months"));
        }
        $report = Report::find($id);
        $data = $report->report_details;
        $name = $report->name;
        $duplicateKeys = $this->duplicateKeys($data);
        $result = $this->generateSqlQuery($data, $duplicateKeys);
        $result .= "where date(created_at) between '" . $startDate . "' and '" . $endDate . "'";
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
            ->select('name', 'report_details', 'users')->get();
        $name = $results[0]->name;
        $report_details = $results[0]->report_details;
        $report_details = json_decode($report_details);
        $selectedTables = [];
        foreach ($report_details->tables as $index => $tables) {
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
        return view('adminViewCreate.edit', ['report_details' => $report_details, 'name' => $name, 'selectedTables' => $selectedTables, 'selectedUsers' => $selectedUsers, 'id' => $id, 'tableNames' => $tableNames, 'users' => $userNames]);
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
        $updatedData = ['report_details' => $data, 'name' => $name, 'users' => $users];
        $report = Report::find($id);
        $report->update($updatedData);
        echo "<pre>";

        return redirect('/view-report-list');
        // unset($request['_token']);
        // unset($request['table']);
        // print_r($request->all());
    }
}
