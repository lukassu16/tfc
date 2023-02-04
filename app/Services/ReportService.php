<?php

namespace App\Services;

use App\Report;
use Illuminate\Http\Request;

class ReportService
{
    public $request;

    public $defaultStatuses = [
        'OPEN', 'TAKEN'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;    
    }

    public function getReports()
    {
        $reportsQuery = Report::query();
        
        if (!Auth()->user()->hasRole('Administrator')) {
            $reportsQuery = $reportsQuery->where('author_id', Auth()->user()->id);
        }

        $reportsQuery = $this->filter($reportsQuery);

        return $reportsQuery->get();
    }

    public function filter($reportsQuery)
    {
        if (request()->has('status')) {
            $reportsQuery->where('status', request('status'));
        } else {
            $reportsQuery->whereIn('status', $this->defaultStatuses);
        }

        return $reportsQuery;
    }
}