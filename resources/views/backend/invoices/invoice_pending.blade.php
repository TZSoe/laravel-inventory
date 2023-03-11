@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Pending Invoices</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Invoice All Data </h4>


                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Customer Name</th>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>

                                @foreach($invoices as $key => $invoice)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td>
                                        {{ $invoice->payment->customer->name }}
                                    </td>
                                    <td> #{{ $invoice->invoice_no }} </td>
                                    <td> {{ date('d-m-Y', strtotime($invoice->date)) }} </td>
                                    <td> {{ $invoice->description }} </td>

                                    <td>{{ $invoice->payment->total_amount }} </td>

                                    <td>
                                        @if($invoice->status == 0)
                                        <span class="btn btn-warning">Pending</span>
                                        @else
                                        <span class="btn btn-success">Approved</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($invoice->status == 0)
                                        <a href="{{ route('invoice.approve', $invoice->id) }}" class="btn btn-dark sm"
                                            title="Approved"> <i class="fas fa-check-circle"></i> </a>

                                        <a href="{{ route('invoice.delete', $invoice->id) }}" class="btn btn-danger sm"
                                            title="Delete Data" id="delete"> <i class="fas fa-trash-alt"></i> </a>
                                        @endif
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