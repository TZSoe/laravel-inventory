<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;

class StockController extends Controller
{
    public function stockReport()
    {
        $products = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('backend.stock.stock_report', compact('products'));
    }


    public function stockReportPdf(Request $request)
    {
        $products = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('backend.pdf.stock_report_pdf', compact('products'));
    }

    public function stockSupplierWise()
    {
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('backend.stock.supplier_product_wise_report', compact('suppliers', 'categories'));
    }

    public function stockSupplierWisePdf(Request $request)
    {
        $products = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->where('supplier_id', $request->supplier_id)->get();

        return view('backend.pdf.supplier_wise_report_pdf', compact('products'));
    }


    public function stockProductWisePdf(Request $request)
    {
        $product = Product::where('category_id', $request->category_id)->where('id', $request->product_id)->first();

        return view('backend.pdf.product_wise_report_pdf', compact('product'));
    }
}
