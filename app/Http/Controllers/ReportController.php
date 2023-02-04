<?php

namespace App\Http\Controllers;

use App\Report;
use App\Services\ReportService;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        $reports = $reportService->getReports();

        return view('reports.index', ['reports' => $reports]);
    }

    public function create()
    {
        // ...
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'category'      => 'required'
        ]);

        Report::create([
            array_merge(
                $request->all(),
                ['author_id' => Auth()->user()->id]
            )
        ]);

        return redirect('/reports');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'status' => Rule::in(['OPEN', 'TAKEN', 'CLOSED'])
        ]);

        $report->update([
            'status' => $request->get('status')
        ]);

        return redirect('/reports');
    }
}
