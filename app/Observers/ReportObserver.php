<?php

namespace App\Observers;

use App\Mail\ChangeStatusNotyfication;
use App\Report;
use Illuminate\Support\Facades\Mail;

class ReportObserver
{
    public function updated(Report $report)
    {
        Mail::to($report->author->email)
            ->send(new ChangeStatusNotyfication());
    }
}
