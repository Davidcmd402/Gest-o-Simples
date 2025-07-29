<?php


namespace App\Services;

use App\Models\Purchase;
use App\Models\Sale;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportService
{

    public function __construct(protected PurchaseService $purchaseService, protected SupplierService $supplierService)
    {
        $this->purchaseService = $purchaseService;
        $this->supplierService = $supplierService;
    }

    public function index(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $salesQuery = Sale::with('product');

        if ($start) {
            $salesQuery->whereDate('created_at', '>=', $start);
        }

        if ($end) {
            $salesQuery->whereDate('created_at', '<=', $end);
        }

        $sales = $salesQuery->get();

        $totalRevenue = $sales->sum(function ($sale) {
            return $sale->quantity * $sale->sale_price;
        });


        // Total invested = purchase_price × quantity
        $totalCost = Purchase::sum(DB::raw('quantity * purchase_price')) ?? 0;

        // Total estimated revenue from current stock = sale_price × quantity
        $totalEstimatedRevenue = DB::table('products')
            ->select(DB::raw('SUM(sale_price * quantity) as total'))
            ->value('total') ?? 0;

        // Estimated profit = estimated revenue − investment
        $estimatedProfit = $totalEstimatedRevenue - $totalCost;

        $totalUnitsSold = $sales->sum('quantity');

        // Most sold product
        $topSellingGroup = $sales->groupBy('product_id')->sortByDesc(function ($group) {
            return $group->sum('quantity');
        })->first();

        $topSellingProduct = $topSellingGroup ? $topSellingGroup->first()->product : null;
        $topSellingQuantity = $topSellingGroup ? $topSellingGroup->sum('quantity') : 0;

        $topProducts = Sale::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->limit(5)
            ->get();

        $monthlySales = DB::table('sales')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(quantity * sale_price) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'totalUnitsSold' => $totalUnitsSold,
            'topSellingProduct' => $topSellingProduct,
            'topSellingQuantity' => $topSellingQuantity,
            'totalCost' => $totalCost,
            'start' => $start,
            'end' => $end,
            'estimatedProfit' => $estimatedProfit,
            'topProducts' => $topProducts,
            'totalEstimatedRevenue' => $totalEstimatedRevenue
        ];
    }
}