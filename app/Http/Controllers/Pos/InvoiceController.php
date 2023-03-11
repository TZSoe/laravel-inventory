<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Payment;
use App\Models\PaymentDetails;
use Illuminate\Support\Facades\DB;
use Propaganistas\LaravelPhone\PhoneNumber;

class InvoiceController extends Controller
{
    public function allInvoices()
    {
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 1)->get();

        return view('backend.invoices.invoice_all', compact('invoices'));
    }

    public function createInvoice()
    {
        $categories = Category::all();
        $invoice_data = Invoice::orderBy('id', 'desc')->first();
        $customers = Customer::all();

        $invoice_no = $invoice_data == null ? 1 : $invoice_data->invoice_no + 1;

        $date = date('Y-m-d');

        return view('backend.invoices.invoice_create', compact('categories', 'invoice_no', 'date', 'customers'));
    }

    public function storeInvoice(Request $request)
    {
        if($request->category_id == null)
        {
            $notification = array(
                'message' => 'Sorry you do not select any item',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }else{
            if($request->paid_amount > $request->estimated_amount)
            {
                $notification = array(
                    'message' => 'Sorry paid amount is maximum the total price',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }else{
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = auth()->user()->id;

                DB::transaction(function() use($request, $invoice){
                    if($invoice->save())
                    {
                        $category_count = count($request->category_id);
                        for($i = 0; $i < $category_count; $i++)
                        {
                            $invoice_details = new InvoiceDetails();
                            $invoice_details->date = date('Y-m-d', strtotime($request->date));
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '0';
                            $invoice_details->save();
                        }

                        if($request->customer_id == '0')
                        {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = (string) new PhoneNumber($request->mobile_no, 'MM');
                            $customer->email = $request->email;
                            $customer->created_by = auth()->user()->id;
                            $customer->save();
                            $customer_id = $customer->id;
                        }else{
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetails();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if($request->paid_status == 'full_paid')
                        {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        }elseif($request->paid_status == 'full_due')
                        {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        }elseif($request->paid_status == 'partial_paid')
                        {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }

                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->date));
                        $payment_details->save();
                    }

                });
            }
        }
        
        $notification = array(
            'message' => 'Invoice data inserted successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('invoice.pending')->with($notification);
    }

    public function pendingInvoices()
    {
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 0)->get();

        return view('backend.invoices.invoice_pending', compact('invoices'));
    }

    public function deleteInvoice(Invoice $invoice)
    {
        InvoiceDetails::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetails::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();

        $notification = array(
            'message' => 'Invoice data deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function approveInvoice(Invoice $invoice)
    {
        $invoice->load(['invoice_details','payment']);
        return view('backend.invoices.invoice_approve', compact('invoice'));
    }

    public function storeInvoiceApprove(Invoice $invoice, Request $request)
    {
        foreach($request->selling_qty as $key => $val)
        {
            $invoice_details = InvoiceDetails::where('id', $key)->first();
            $product = Product::where('id', $invoice_details->product_id)->first();

            if($product->quantity < $request->selling_qty[$key])
            {
                $notification = array(
                    'message' => 'Sorry you approve maximum value',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }
        }

        $invoice->updated_by = auth()->user()->id;
        $invoice->status = '1';

        DB::transaction(function() use($request, $invoice){
            foreach($request->selling_qty as $key => $val)
            {
                $invoice_details = InvoiceDetails::where('id', $key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
                
                $product = Product::where('id', $invoice_details->product_id)->first();
                $product->quantity = $product->quantity - $val;
                $product->save();
            }
            
            $invoice->save();
        });

        $notification = array(
            'message' => 'Invoice approve successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('invoice.pending')->with($notification);
    }

    public function printInvoiceList()
    {
        $invoices = Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', 1)->get();

        return view('backend.invoices.print_invoice_list', compact('invoices'));
    }

    public function printInvoice(Invoice $invoice)
    {
        return view('backend.pdf.invoice', compact('invoice'));
    }

    public function dailyInvoiceReport()
    {
        return view('backend.invoices.daily_report');
    }

    public function dailyInvoicePdf(Request $request)
    {
        $start_date = date('Y-m-d', strtotime($request->start_date));

        $end_date = date('Y-m-d', strtotime($request->end_date));

        $invoices = Invoice::whereBetween('date', [$start_date, $end_date])->where('status', 1)->get();

        return view('backend.pdf.daily_invoice_report_pdf', compact('invoices', 'start_date', 'end_date'));
    }
}
