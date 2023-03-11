@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer All</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('customer.create') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i
                                class="fas fa-plus-circle"></i> Add
                            Customer</a>
                        <br /><br />

                        <h4 class="card-title">Customer All Data </h4>


                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>

                            </thead>


                            <tbody>

                                @foreach($customers as $key => $customer)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td> {{ $customer->name }} </td>
                                    <td>
                                        <img src="{{ $customer->customer_image ? asset($customer->customer_image) : asset('upload/no_image.jpg') }}"
                                            alt="Customer Image" style="width:60px;height:50px;">
                                    </td>
                                    <td> {{ $customer->email }} </td>
                                    <td> {{ $customer->address }} </td>
                                    <td>
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-info sm"
                                            title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                        <a href="{{ route('customer.delete', $customer->id) }}"
                                            class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                class="fas fa-trash-alt"></i> </a>

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