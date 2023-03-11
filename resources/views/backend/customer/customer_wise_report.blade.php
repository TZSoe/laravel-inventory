@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Wise Report</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <strong>Customer Wise Credit Report</strong>
                                <input type="radio" name="customer_wise_report" value="credit" class="search_value"
                                    checked> &nbsp;

                                <strong>Customer Wise Paid Report</strong>
                                <input type="radio" name="customer_wise_report" value="paid" class="search_value">
                            </div>
                        </div>


                        <div class="show_credit">
                            <form method="GET" action="{{ route('customer.wise.credit.report') }}" target="_blank"
                                id="myForm">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label>Customer Name </label>
                                        <select class="form-control select2" aria-label="Default select example"
                                            name="customer_id">
                                            <option value="">Choose Customer</option>

                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" @if(old('customer_id')==$customer->
                                                id)
                                                selected @endif>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4" style="padding-top: 25px;">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Paid Wise -->
                        <div class="show_paid">
                            <form method="GET" action="{{ route('customer.wise.paid.report') }}" target="_blank"
                                id="myForm">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label>Customer Name </label>
                                        <select class="form-control select2" aria-label="Default select example"
                                            name="customer_id">
                                            <option value="">Choose Customer</option>

                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" @if(old('customer_id')==$customer->
                                                id)
                                                selected @endif>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4" style="padding-top: 25px;">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>

<script>
    $(function(){
        $('.show_paid').hide();
    })
</script>

<script>
    $(document).on('change', '.search_value', function(){
        var search_value = $(this).val();
        if(search_value == "credit")
        {
            $(".show_credit").show();
        }else{
            $(".show_credit").hide();
        }
    });
</script>

<script>
    $(document).on('change', '.search_value', function(){
        var search_value = $(this).val();
        if(search_value == "paid")
        {
            $(".show_paid").show();
        }else{
            $(".show_paid").hide();
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                customter_id: {
                    required : true,
                }
            },
            messages :{
                customter_id: {
                    required : 'Please Select Customer',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
@endsection