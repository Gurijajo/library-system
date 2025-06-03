<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SystemCheckService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SystemCheckController extends Controller
{
    protected SystemCheckService $systemCheckService;

    public function __construct(SystemCheckService $systemCheckService)
    {
        $this->systemCheckService = $systemCheckService;
        $this->middleware(['auth', 'role:admin,librarian']);
    }

    /**
     * Show system check page
     * Created by: Guram-jajanidze
     */
    public function index()
    {
        return view('admin.system-check.index');
    }

    /**
     * Run system check via AJAX
     */
    public function runCheck(Request $request)
    {
        $report = $this->systemCheckService->runCompleteCheck();
        
        if ($request->wantsJson()) {
            return response()->json($report);
        }

        return redirect()->back()->with([
            'system_check_report' => $report,
            'success' => 'System check completed successfully!'
        ]);
    }

    /**
     * Download system check report
     */
    public function downloadReport()
    {
        $report = $this->systemCheckService->runCompleteCheck();
        $filename = $this->systemCheckService->saveReport($report);
        
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        return Response::make(
            json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            200,
            $headers
        );
    }
}