<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        return view('report.index');
    }

    public function show(Request $request) {
        $request->validate([
            'start_date' => 'required|date_format:d.m.Y',
            'end_date' => 'required|date_format:d.m.Y'
        ]);
    
    
        $startDate = \DateTime::createFromFormat('d.m.Y', $request->start_date)->format('Y-m-d').' 00:00:00';
        $endDate = \DateTime::createFromFormat('d.m.Y', $request->end_date)->format('Y-m-d').' 23:59:59';
    
        $salesQuery = Sale::whereBetween('updated_at', [$startDate, $endDate])->where('sale_status', 'paid');
    
        $totalSale = $salesQuery->sum('total_price');
    
        $sales = $salesQuery->paginate(5);
    
        return view('report.show-report', [
            'start_date' => date('d.m.Y H:i:s', strtotime($startDate)),
            'end_date' => date('d.m.Y H:i:s', strtotime($endDate)),
            'totalSale' => $totalSale,
            'sales' => $sales
        ]);
    }
}
