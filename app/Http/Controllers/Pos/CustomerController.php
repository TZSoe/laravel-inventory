<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\PaymentDetails;
use Image;
use Propaganistas\LaravelPhone\PhoneNumber;


class CustomerController extends Controller
{
    public function allCustomers()
    {
        $customers = Customer::latest()->get();

        return view('backend.customer.customer_all', compact('customers'));
    }

    public function createCustomer()
    {
        return view('backend.customer.customer_create');
    }

    public function storeCustomer(Request $request)
    {
        $image = $request->file('customer_image');
        $filename = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::make($image)->resize(200, 200)->save('upload/customer/'.$filename)->destroy();

        $save_url = 'upload/customer/'.$filename;

        Customer::create([
            'name' => $request->name,
            'customer_image' => $save_url,
            'mobile_no' => (string) new PhoneNumber($request->mobile_no, 'MM'),
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => auth()->user()->id
        ]);

        $notification = array(
            'message' => 'Customer created successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }

    public function editCustomer(Customer $customer)
    {
        return view('backend.customer.customer_edit', compact('customer')); 
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $request->validate([
            'mobile_no' => 'phone:MM'
        ]);

        $data = [
            'name' => $request->name,
            'mobile_no' => (string) new PhoneNumber($request->mobile_no, 'MM'),
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => auth()->user()->id
        ];

        if($request->file('customer_image'))
        {
            $image = $request->file('customer_image');
            $filename = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(200, 200)->save('upload/customer/'.$filename)->destroy();

            unlink($customer->customer_image);

            $save_url = 'upload/customer/'.$filename;
            $data['customer_image'] = $save_url;
        }

        $customer = $customer->update($data);

        $notification = array(
            'message' => 'Customer updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }

    public function deleteCustomer(Customer $customer)
    {
        unlink($customer->customer_image);
        $customer->delete();

        $notification = array(
            'message' => 'Customer deleted successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function creditCustomers()
    {
        $payments = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();

        return view('backend.customer.credit_customer', compact('payments'));
    }

    public function printCreditCustomers()
    {
        $payments = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();

        return view('backend.pdf.credit_customer_pdf', compact('payments'));
    }

    public function customerEditInvoice(Invoice $invoice)
    {
        $payment = Payment::where('invoice_id', $invoice->id)->first();
        
        return view('backend.customer.customer_invoice_edit', compact('payment'));
    }


    public function customerUpdateInvoice(Invoice $invoice, Request $request)
    {
        if($request->new_paid_amount < $request->paid_amount)
        {
            $notification = array(
                'message' => 'Sorry You Paid Maximum Value',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }else{
            $payment = Payment::where('invoice_id', $invoice->id)->first();
            $payment_details = new PaymentDetails();
            $payment->paid_status = $request->paid_status;

            if($request->paid_status == 'full_paid')
            {
                $payment->paid_amount = $payment->paid_amount + $request->new_paid_amount;
                $payment->due_amount = 0;
                $payment_details->current_paid_amount = $request->new_paid_amount;
            }else if($request->paid_status == 'partial_paid'){
                $payment->paid_amount = $payment->paid_amount + $request->paid_amount;
                $payment->due_amount = $payment->due_amount - $request->paid_amount;
                $payment_details->current_paid_amount = $request->paid_amount;
            }

            $payment->save();
            $payment_details->invoice_id = $invoice->id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->updated_by = auth()->user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Invoice Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.credit')->with($notification);
        }
    }

    public function customerInvoiceDetailsPdf(Invoice $invoice)
    {
        $payment = Payment::where('invoice_id', $invoice->id)->first();

        return view('backend.pdf.customer_invoice_details', compact('payment'));
    }

    public function paidCustomer()
    {
        $payments = Payment::where('paid_status', '!=', 'full_due')->get();

        return view('backend.customer.paid_customer', compact('payments'));
    }


    public function paidCustomerPrintPdf()
    {
        $payments = Payment::where('paid_status', '!=', 'full_due')->get();

        return view('backend.pdf.paid_customer_pdf', compact('payments'));
    }

    public function customerWiseReport()
    {
        $customers = Customer::all();

        return view('backend.customer.customer_wise_report', compact('customers'));
    }

    public function customerWiseCreditReport(Request $request)
    {
        $payments = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->where('customer_id', $request->customer_id)->get();

        return view('backend.pdf.customer_wise_credit_pdf', compact('payments'));
    }


    public function customerWisePaidReport(Request $request)
    {
        $payments = Payment::where('paid_status', '!=', 'full_due')->where('customer_id', $request->customer_id)->get();

        return view('backend.pdf.customer_wise_paid_pdf', compact('payments'));
    }
}
