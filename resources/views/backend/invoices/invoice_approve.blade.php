@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Invoice Approve</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        @php
        $payment = \App\Models\Payment::where('invoice_id', $invoice->id)->first();
        @endphp

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4>Invoice No : #{{ $invoice->invoice_no }} - {{ date('d-m-Y', strtotime($invoice->date)) }}
                        </h4>

                        <a href="{{ route('invoice.pending') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i
                                class="fas fa-list"></i> Pending Invoice List</a>
                        <br /><br />

                        <table class="table table-dark" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Customer Info</p>
                                    </td>
                                    <td>
                                        <p>Name : <strong> {{ $payment->customer->name }}</strong></p>
                                    </td>
                                    <td>
                                        <p>Mobile : <strong> {{ $payment->customer->mobile_no }}</strong></p>
                                    </td>
                                    <td>
                                        <p>Email : <strong> {{ $payment->customer->email }}</strong></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        <p>Description : <strong> {{ $invoice->description }}</strong></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <form action="{{ route('invoice.approve.store', $invoice->id) }}" method="POST">
                            @csrf
                            <table border="1" class="table table-dark" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center" style="background-color: #88008B">Current Stock</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-center">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total_sum = 0;
                                    @endphp
                                    @foreach($invoice->invoice_details as $key => $item)

                                    <input type="hidden" name="category_id[]" value="{{ $item->category_id }}">
                                    <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                    <input type="hidden" name="selling_qty[{{$item->id}}]"
                                        value="{{ $item->selling_qty }}">

                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">{{ $item->category->name }}</td>
                                        <td class="text-center">{{ $item->product->name }}</td>
                                        <td class="text-center" style="background-color: #88008B">{{
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
                                        <td colspan="6">Sub Total</td>
                                        <td class="text-center">{{ $total_sum }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="6">Discount</td>
                                        <td class="text-center">{{ $payment->discount_amount }}</td>
                                    </tr>


                                    <tr>
                                        <td colspan="6">Paid Amount</td>
                                        <td class="text-center">{{ $payment->paid_amount }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="6">Due Amount</td>
                                        <td class="text-center">{{ $payment->due_amount }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="6">Grand Total Amount</td>
                                        <td class="text-center">{{ $payment->total_amount }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-info">Approve Invoice</button>
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection