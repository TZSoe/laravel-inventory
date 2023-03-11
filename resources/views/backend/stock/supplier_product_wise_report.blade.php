@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Supplier/Product Wise Stock Report</h4>

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
                                <strong>Supplier Wise Stock Report</strong>
                                <input type="radio" name="supplier_product_wise" value="supplier_wise"
                                    class="search_value" checked> &nbsp;

                                <strong>Product Wise Stock Report</strong>
                                <input type="radio" name="supplier_product_wise" value="product_wise"
                                    class="search_value">
                            </div>
                        </div>


                        <div class="show_supplier">
                            <form method="GET" action="{{ route('stock.supplier.wise.pdf') }}" target="_blank"
                                id="myForm">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label>Supplier Name </label>
                                        <select class="form-control select2" aria-label="Default select example"
                                            name="supplier_id">
                                            <option value="">Choose Supplier</option>

                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" @if(old('supplier_id')==$supplier->
                                                id)
                                                selected @endif>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4" style="padding-top: 25px;">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Product Wise -->
                        <div class="show_product">
                            <form method="GET" action="{{ route('stock.product.wise.pdf') }}" target="_blank"
                                id="myForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input">Category</label>
                                            <select class="form-control select2" aria-label="Default select example"
                                                name="category_id" id="category_id">
                                                <option value="">Choose Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if(old('category_id')==$category->
                                                    id)
                                                    selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="md-3">
                                            <label for="example-text-input">Product Name</label>
                                            <select class="form-control select2" aria-label="Default select example"
                                                name="product_id" id="product_id">
                                                <option selected="" value="">Choose Product</option>


                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="padding-top: 25px;">
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
        $('.show_product').hide();
    })
</script>

<script>
    $(function(){
        $(document).on('change', '#category_id', function(){
            var category_id = $(this).val();
            $.ajax({
                url: "{{ route('get-product') }}",
                type: "GET",
                data: {
                    category_id: category_id
                },
                success: function(data){
                    var html = '<option value="">Select Product</option>';
                    $.each(data, function(key, value){
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                
                    $('#product_id').html(html);
                }
            });
        });


        $(document).on('change', '#product_id', function(){
            var product_id = $(this).val();
            $.ajax({
                url: "{{ route('get-product-stock') }}",
                type: "GET",
                data: {
                    product_id: product_id
                },
                success: function(data){
                    $('#current_stock_qty').val(data);
                }
            });
        });
    });
</script>

<script>
    $(document).on('change', '.search_value', function(){
        var search_value = $(this).val();
        if(search_value == "supplier_wise")
        {
            $(".show_supplier").show();
        }else{
            $(".show_supplier").hide();
        }
    });
</script>

<script>
    $(document).on('change', '.search_value', function(){
        var search_value = $(this).val();
        if(search_value == "product_wise")
        {
            $(".show_product").show();
        }else{
            $(".show_product").hide();
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                supplier_id: {
                    required : true,
                }
            },
            messages :{
                supplier_id: {
                    required : 'Please Select Supplier',
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