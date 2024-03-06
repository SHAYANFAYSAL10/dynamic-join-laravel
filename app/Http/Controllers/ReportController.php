<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use DB;

class ReportController extends Controller
{

    protected function generateSqlQuery($data)
    {
        $sql = "SELECT ";

        // Select columns from tables
        foreach ($data['tables'] as $table => $columns) {
            foreach ($columns as $column) {
                $sql .= "$table.$column, ";
            }
        }

        // Remove the trailing comma and space
        $sql = rtrim($sql, ', ');

        // Join tables
        $flag = false;
        $sql .= " from ";
        foreach ($data['joins'] as $join) {
            if ($flag === false) {
                $flag = true;
                $sql .= "{$join['left_table']} ";
            }
            $sql .= " {$join['join_type']} JOIN {$join['right_table']} ON {$join['left_table']}.{$join['left_column']} = {$join['right_table']}.{$join['right_column']}";
        }
        return $sql;
    }

    protected function generateSqlQuery2($data, $duplicateKeys)
    {
        $selectColumns = [];
        $tableNames = [];

        foreach ($data['tables'] as $indexes => $tables) {
            // Loop through each column in the table
            foreach ($tables as $tablename => $columns) {
                $tableNames[] = $tablename;
                foreach ($columns as $column) {
                    $selectColumns[] = in_array($column, $duplicateKeys) != 0 ? "$tablename.$column as {$tablename}_{$column}" : "$tablename.$column";
                }
            }
        }
        // foreach ($data['tables'] as $table => $columns) {
        //     foreach ($columns as $column) {
        //         // $selectColumns[] = "$table.$column";

        //         $selectColumns[] = in_array($column, $duplicateKeys) != 0 ? "$table.$column as {$table}_{$column}" : "$table.$column";
        //     }
        // }
        $selectColumns = implode(', ', $selectColumns);

        // dd($tableNames);
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

    protected function generateSqlQuery3($data)
    {
        $selectColumns = collect($data['tables']);
        // ->flatMap(function ($columns, $table){});
        dd($selectColumns);
        // $selectColumns = collect($data['tables'])
        //     ->flatMap(function ($columns, $table) {
        //         return collect($columns)->map(function ($column) use ($table) {
        //             return "$column" === "id" ?"$table.$column"." as $table" . "_" . "$column":  "$table.$column";
        //         });
        //     })
        //     ->implode(', ');

        // $joinClauses = collect($data['joins'])
        //     ->reduce(function ($carry, $join, $index) {
        //         $tableAlias = $index === 0 ? $join['left_table'] : "";
        //         $carry .=$tableAlias." ";
        //         $carry .= "{$join['join_type']} JOIN {$join['right_table']} ON {$join['left_table']}.{$join['left_column']} = {$join['right_table']}.{$join['right_column']} ";

        //         return $carry;
        //     }, '');

        // return "SELECT $selectColumns FROM $joinClauses";
        return "select";
    }

    protected function generateSqlQuery4($data)
    {
        // $firstTable = array_keys($data['tables'][0])[0];
        // dd($firstTable);
        $firstTable = array_keys($data['tables'])[0];
        // $childKeys = array_keys($data['tables'][$firstTable]);
        // $value = $data['tables'][0];
        // $value2 = array_keys($value);
        $query = DB::table($firstTable);
        // $tableNames = array_keys($data['tables']);
        // $tableNames = [];
        // foreach ($data['tables'] as $key => $value) {
        //     if (is_string($key)) {
        //         $tableNames[] = $key;
        //     }
        // }
        // dd($value2);
        $eachColumnNameCount = [];

        foreach ($data['tables'] as $table => $columns) {
            foreach ($columns as $column) {
                $eachColumnNameCount[$column] = ($eachColumnNameCount[$column] ?? 0) + 1;
                if ($eachColumnNameCount[$column] > 1) {
                    $query->addSelect("$table.$column as {$table}_{$column}");
                } else {
                    $query->addSelect("$table.$column");
                }
            }
        }
        // dd($eachColumnNameCount);
        $index = 1;
        foreach ($data['joins'] as $join) {
            if ($join['join_type'] === 'cross') {
                $query->crossJoin(array_keys($data['tables'])[$index]);
            } else {
                $query->join(
                    array_keys($data['tables'])[$index],
                    "$join[left_table].$join[left_column]",
                    '=',
                    "$join[right_table].$join[right_column]",
                    $join['join_type']
                );
            }
            $index++;
        }
        // dd($query);
        return $query;
    }


    protected function duplicateKeys($data)
    {

        $duplicateKeys = [];
        $encounteredKeys = [];

        // Loop through each table
        foreach ($data['tables'] as $indexes => $tables) {
            // Loop through each column in the table
            foreach ($tables as $tablename => $columns) {
                foreach ($columns as $column) {
                    // Check if the column key has been encountered before
                    // echo $column;
                    if (in_array($column, $encounteredKeys)) {
                        // Duplicate key found
                        $duplicateKeys[] = $column;
                    } else {
                        // Record the encountered key
                        $encounteredKeys[] = $column;
                    }
                }
            }
        }

        // foreach ($data['tables'] as $tableName => $tableColumns) {
        //     // Loop through each column in the table
        //     foreach ($tableColumns as $column) {
        //         echo $column;
        //         // Check if the column key has been encountered before
        //         if (in_array($column, $encounteredKeys)) {
        //             // Duplicate key found
        //             $duplicateKeys[] = $column;
        //         } else {
        //             // Record the encountered key
        //             $encounteredKeys[] = $column;
        //         }
        //     }
        // }

        // dd($duplicateKeys);

        return $duplicateKeys;
    }



    public function index()
    {

        $report = Report::find(8);
        $data = $report->view;


        // echo "<pre>";
        // print_r($data);
        // dd($data);
        // $data = $request->all(); // Assuming the JSON structure is submitted in the request

        // $result = $query->get();


        $duplicateKeys = $this->duplicateKeys($data);
        // dd($duplicateKeys);
        $result = $this->generateSqlQuery2($data, $duplicateKeys);

        // dd($result);
        // // $tableKeys = array_keys($viewJson['tables']);

        // // // $tableNames = DB::select('SHOW TABLES');
        // // // $tableNames = array_map('current', $tableNames);

        // // $sql=getDataFromSql($report->view);
        // // $sql = $this->generateSqlQuery($data);
        // 

        $result = DB::select($result);
        // echo $sql;
        // foreach ($result as $row) {
        //     echo "ID: {$row->id}, Student Name: {$row->student_name}, Age: {$row->student_age}, Grade: {$row->student_grade}, Teacher Name: {$row->teacher_name}, Marks Obtained: {$row->marks_obtained}, Subject Name: {$row->subject_name}<br>";
        // }
        // foreach ($result as $row) {
        //     $attributes = get_object_vars($row);

        //     // Echo each attribute
        //     foreach ($attributes as $attribute => $value) {
        //         echo ucfirst($attribute) . ": $value, ";
        //     }

        //     echo "<br>";
        // }
        // dd($result);
        return view('jsonjoin.index', ['data' => $result]);
        // return view('jsonjoin.index',"hello");
    }
}
