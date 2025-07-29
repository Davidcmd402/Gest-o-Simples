<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;


class ReportController extends Controller
{

    public function __construct(protected ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function index(Request $request)
    {
        $data = $this->reportService->index($request);

        return view('report.index')->with($data);
    }
}