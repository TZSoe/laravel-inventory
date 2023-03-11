@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Paid Customer All</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('paid.customer.print.pdf') }}" target="_blank"
                            class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i
                                class="fas fa-print"></i> Print Paid
                            Customers</a>
                        <br /><br />

                        <h4 class="card-title">Paid Customers Data </h4>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Due Amount</th>
                                    <th>Action</th>
                            </thead>


                            <tbody>

                                @foreach($payments as $key => $payment)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td> {{ $payment->customer->name }} </td>
                                    <td>
                                        #{{ $payment->invoice->invoice_no }}
                                    </td>
                                    <td> {{ date('d-m-Y', strtotime($payment->invoice->date)) }} </td>
                                    <td> {{ $payment->due_amount }} </td>
                                    <td>
                                        <a href="{{ route('customer.invoice.details.pdf', $payment->invoice_id) }}"
                                            target="_blank" class="btn btn-info sm" title="Customer Details"> <i
                                                class="fas fa-eye"></i> </a>



                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>


@endsection