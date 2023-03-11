@extends('admin.admin_master')

@section('admin')
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

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">

                                    <h3>
                                        <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo"
                                            height="24"> Easy Shopping Mall
                                    </h3>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-6 mt-4">
                                        <address>
                                            <strong>Easy Shopping Mall :</strong><br>
                                            Amarapura, Mandalay<br>
                                            support@easyshopping.com
                                        </address>
                                    </div>
                                    <div class="col-6 mt-4 text-end">
                                        <address>

                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div>

                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div>

                                    </div>
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td><strong>No</strong></td>
                                                        <td class="text-center"><strong>Supplier Name</strong></td>
                                                        <td class="text-center"><strong>Unit</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Category</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Product Name</strong>
                                                        </td>
                                                        <td class="text-center"><strong>In Qty</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Out Qty</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Quantity</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($products as $key => $product)

                                                    @php
                                                    $buying_total = \App\Models\Purchase::where('category_id',
                                                    $product->category_id)->where('product_id',
                                                    $product->id)->where('status',
                                                    1)->sum('buying_qty');

                                                    $selling_total = \App\Models\InvoiceDetails::where('category_id',
                                                    $product->category_id)->where('product_id',
                                                    $product->id)->where('status',
                                                    '1')->sum('selling_qty');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td class="text-center">{{ $product->supplier->name }}
                                                        </td>
                                                        <td class="text-center">{{ $product->unit->name }}</td>
                                                        <td class="text-center">{{ $product->category->name }}</td>
                                                        <td class="text-center">{{
                                                            $product->name }}</td>
                                                        <td class="text-center">{{
                                                            $buying_total }}</td>
                                                        <td class="text-center">{{
                                                            $selling_total }}</td>
                                                        <td class="text-center">{{ $product->quantity }}
                                                        </td>
                                                    </tr>

                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                        @php
                                        $date = new DateTime('now', new DateTimeZone('Asia/Yangon'));
                                        @endphp
                                        <i>Printing Time : {{ $date->format('F j, Y, g:i a') }}</i>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()"
                                                    class="btn btn-success waves-effect waves-light"><i
                                                        class="fa fa-print"></i></a>
                                                <a href="#"
                                                    class="btn btn-primary waves-effect waves-light ms-2">Download</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end row -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
</div>
@endsection