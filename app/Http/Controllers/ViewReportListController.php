<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use DB;

class ViewReportListController extends Controller
{
    public function index()
    {
        $reports = DB::table('reports')->get();
        // $reports = Report::all();
        // dd($reports);
        return view('reportList.index', ['reports' => $reports]);
    }
}
