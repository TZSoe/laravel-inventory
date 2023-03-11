@extends('admin.admin_master')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css" media="print">
    @page {
        margin-top: 0;
        margin-bottom: 0;
    }

    body {
        padding-top: 50px;
        padding-bottom: 50px;
    }
</style>
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('customer.credit') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i
                                class="fas fa-list"></i> Back</a>
                        <br /><br />

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div>
                                        <h3 class="font-size-16"><strong>Customer Invoice ( Invoice No : #{{
                                                $payment->invoice->invoice_no }} )</strong></h3>
                                    </div>
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>Customer Name</strong></td>
                                                        <td class="text-center"><strong>Customer Mobile</strong></td>
                                                        <td class="text-center"><strong>Address</strong>
                                                        </td>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                    <tr>
                                                        <td>{{ $payment->customer->name }}</td>
                                                        <td class="text-center">{{ $payment->customer->mobile_no }}</td>
                                                        <td class="text-center">{{ $payment->customer->email }}</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                        <form action="{{ route('customer.update.invoice', $payment->invoice_id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>No</strong></td>
                                                            <td class="text-center"><strong>Category</strong></td>
                                                            <td class="text-center"><strong>Product Name</strong>
                                                            </td>
                                                            <td class="text-center"><strong>Current Stock</strong>
                                                            </td>
                                                            <td class="text-center"><strong>Quantity</strong>
                                                            </td>
                                                            <td class="text-center"><strong>Unit Price</strong>
                                                            </td>
                                                            <td class="text-center"><strong>Total Price</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $total_sum = 0;
                                                        $invoice_details =
                                                        \App\Models\InvoiceDetails::where('invoice_id',
                                                        $payment->invoice_id)->get();

                                                        @endphp
                                                        @foreach($invoice_details as $key => $item)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td class="text-center">{{ $item->category->name }}</td>
                                                            <td class="text-center">{{ $item->product->name }}</td>
                                                            <td class="text-center">{{
                                                                $item->product->quantity }}</td>
                                                            <td class="text-center">{{ $item->selling_qty }}</td>
                                                            <td class="text-center">{{ $item->unit_price }}</td>
                                                            <td class="text-center">{{ $item->selling_price }}</td>
                                                        </tr>
                                                        @php
                                                        $total_sum += $item->selling_price;
                                                        @endphp
                                                        @endforeach

                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line text-center">
                                                                <strong>Subtotal</strong>
                                                            </td>
                                                            <td class="thick-line text-center">{{ $total_sum }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Discount</strong>
                                                            </td>
                                                            <td class="no-line text-center">{{ $payment->discount_amount
                                                                }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Paid Amount</strong>
                                                            </td>
                                                            <td class="no-line text-center">{{ $payment->paid_amount }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Due Amount</strong>
                                                            </td>
                                                            <input type="hidden" name="new_paid_amount"
                                                                value="{{ $payment->due_amount }}">
                                                            <td class="no-line text-center">{{ $payment->due_amount }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Grand Total Amount</strong>
                                                            </td>
                                                            <td class="no-line text-center">
                                                                <h4 class="m-0">{{ $payment->total_amount }}</h4>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label> Paid Status</label>
                                    <select name="paid_status" id="paid_status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="full_paid">Full Paid</option>
                                        <option value="partial_paid">Partial Paid</option>
                                    </select>
                                    <input type="text" name="paid_amount" class="form-control paid_amount"
                                        placeholder="Enter Paid Amount" style="margin-top:10px;display:none;">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="example-text-input">Date</label>
                                    <input class="form-control" type="date" name="date" id="date"
                                        placeholder="YYYY-MM-DD">
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info" style="margin-top: 27px;">Invoice
                                        Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
</div>

<script>
    $(document).on('change', '#paid_status', function(){
        var paid_status = $(this).val();
        if(paid_status == "partial_paid")
        {
            $(".paid_amount").show();
        }else{
            $(".paid_amount").hide();
        }
    });
</script>
@endsection