<?php

namespace App\Exports;


use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleReportExport implements FromView
{

    private $startDate;
    private $endDate;
    private $sales;
    private $totalSale;


    public function __construct($startDate, $endDate) {
      
        $sales = Sale::whereBetween('updated_at', [$startDate, $endDate])->where('sale_status', 'paid')->get();
        $totalSale = $sales->sum('total_price');

        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->sales = $sales;
        $this->totalSale = $totalSale;
    }
    
    public function view(): View {
        return view('exports.sale-report',[
            'sales' => $this->sales,
            'total_sale' => $this->totalSale,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate
        ]);
    }
}
