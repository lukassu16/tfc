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
        $validatedData = $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'category'      => 'required'
        ]);

        $report = Report::create($validatedData + [
            'author_id'     => auth()->user()->id
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
            'status' => Rule::in([
                Report::OPEN_STATUS,
                Report::CLOSED_STATUS,
                Report::TAKEN_STATUS
            ])
        ]);

        $report->update([
            'status' => $request->get('status')
        ]);

        return redirect('/reports');
    }
}
