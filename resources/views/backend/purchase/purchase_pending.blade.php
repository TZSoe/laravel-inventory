@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Pending Purchases</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Purchase All Data </h4>


                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Purchase No</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Category</th>
                                    <th>Qty</th>
                                    <th>Product Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>

                                @foreach($purchases as $key => $purchase)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td> {{ $purchase->purchase_no }} </td>
                                    <td> {{ date('d-m-Y', strtotime($purchase->date)) }} </td>
                                    <td> {{ $purchase->supplier->name }} </td>
                                    <td> {{ $purchase->category->name }} </td>
                                    <td> {{ $purchase->buying_qty }} </td>
                                    <td> {{ $purchase->product->name }} </td>
                                    <td>
                                        @if($purchase->status == 0)
                                        <span class="btn btn-warning">Pending</span>
                                        @else
                                        <span class="btn btn-success">Approved</span>
                                        @endif
                                    </td>
                                    <td>

                                        @if($purchase->status == 0)
                                        <a href="{{ route('purchase.approve', $purchase->id) }}"
                                            class="btn btn-danger sm" title="Approved" id="approveBtn"> <i
                                                class="fas fa-check-circle"></i> </a>
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