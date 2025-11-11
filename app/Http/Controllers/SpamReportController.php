<?php

namespace App\Http\Controllers;

//use App\Models\Report;
use App\Models\Spam_Reports;

class SpamReportController extends Controller
{
    //
    public function index()
    {
        $reports = Spam_Reports::with('reporter', 'reportable')->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }
}
