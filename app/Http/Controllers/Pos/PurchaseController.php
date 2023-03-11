<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;

class PurchaseController extends Controller
{
    public function allPurchases()
    {
        $purchases = Purchase::orderBy('date', 'DESC')->orderBy('id','desc')->get();
        return view('backend.purchase.purchase_all', compact('purchases'));
    }

    public function createPurchase()
    {
        $suppliers = Supplier::all();

        return view('backend.purchase.purchase_create', compact('suppliers'));
    }

    public function storePurchase(Request $request)
    {
        if($request->category_id == null)
        {
            $notification = array(
                'message' => 'Sorry you do not select any item',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }else {
            $category_count = count($request->category_id);

            for($i = 0; $i < $category_count; $i++)
            {
                Purchase::create([
                    'date' => date('Y-m-d', strtotime($request->date[$i])),
                    'purchase_no' => $request->purchase_no[$i],
                    'supplier_id' => $request->supplier_id[$i],
                    'category_id' => $request->category_id[$i],
                    'product_id' => $request->product_id[$i],
                    'buying_qty' => $request->buying_qty[$i],
                    'unit_price' => $request->unit_price[$i],
                    'buying_price' => $request->buying_price[$i],
                    'description' => $request->description[$i],
                    'created_by' => auth()->user()->id
                ]);
            }
        }
        

        $notification = array(
            'message' => 'Purchase created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('purchase.all')->with($notification);
    }

    public function deletePurchase(Purchase $purchase)
    {
        $purchase->delete();

        $notification = array(
            'message' => 'Purchase deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('purchase.all')->with($notification);
    }

    public function pendingPurchases()
    {
        $purchases = Purchase::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 0)->get();

        return view('backend.purchase.purchase_pending', compact('purchases'));
    }

    public function approvePurchase(Purchase $purchase)
    {
        $product = Product::where('id', $purchase->product_id)->first();

        $purchase_qty = ((float) $purchase->buying_qty) + ((float) $product->quantity);
        $product->quantity = $purchase_qty;
        if($product->save())
        {
            $purchase->update([
                'status' => 1
            ]);

            $notification = array(
                'message' => 'Purchase approved successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('purchase.all')->with($notification);
        }
    }

    public function dailyPurchaseReport()
    {
        return view('backend.purchase.daily_purchase_report');
    }

    public function dailyPurchaseReportPdf(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));

        $end_date = date('Y-m-d', strtotime($request->end_date));

        $purchases = Purchase::whereBetween('date', [$start_date, $end_date])->where('status', 1)->get();

        return view('backend.pdf.daily_purchase_report_pdf', compact('purchases', 'start_date', 'end_date'));
    }
}
