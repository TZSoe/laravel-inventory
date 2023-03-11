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
                                        <h3 class="font-size-16"><strong>Daily Invoice Report
                                                <span class="btn btn-info">{{ date('d-m-Y', strtotime($start_date))
                                                    }}</span> -
                                                <span class="btn btn-success">{{ date('d-m-Y', strtotime($end_date))
                                                    }}</span>
                                            </strong></h3>
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
                                                        <td class="text-center"><strong>Customer Name</strong></td>
                                                        <td class="text-center"><strong>Invoice No</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Date</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Description</strong>
                                                        </td>
                                                        <td class="text-center"><strong>Amount</strong>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $total_sum = 0;
                                                    @endphp
                                                    @foreach($invoices as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td class="text-center">{{ $item->payment->customer->name }}
                                                        </td>
                                                        <td class="text-center">{{ $item->invoice_no }}</td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->date))
                                                            }}</td>
                                                        <td class="text-center">{{
                                                            $item->description }}</td>
                                                        <td class="text-center">{{ $item->payment->total_amount }}</td>
                                                    </tr>
                                                    @php
                                                    $total_sum += $item->payment->total_amount;
                                                    @endphp
                                                    @endforeach


                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Grand Total Amount</strong>
                                                        </td>
                                                        <td class="no-line text-center">
                                                            <h4 class="m-0">{{ $total_sum }}</h4>
                                                        </td>
                                                    </tr>
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