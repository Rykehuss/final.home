<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Campaign;
use App\Models\Record;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::orderBy('id', 'desc')->owned()->get();
        return view('report.index', compact('reports'));
    }

    /**
     * Create a new report.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createNew(Campaign $campaign)
    {
        $report = new Report;
        $report->campaign_id = $campaign->id;
        $report->save();
        return $report;
    }

    /**
     * Display the specified resource.
     *
     * @param  Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $records = Record::where('report_id', $report->id)->get();

        //        updateRecords($records);


        return view('report.show', compact('report', 'records'));
    }
}
