@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Product Page </h4><br><br>


                        <form method="post" action="{{ route('product.edit', $product->id) }}" id="myForm">
                            @csrf
                            @method("PUT")

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="form-group col-sm-10">
                                    <input name="name" class="form-control" type="text" value="{{ $product->name }}">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Supplier</label>
                                <div class="form-group col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="supplier_id">
                                        <option selected="">Choose Supplier</option>

                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @if($product->supplier_id == $supplier->id)
                                            selected @endif>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Unit</label>
                                <div class="form-group col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="unit_id">
                                        <option selected="">Choose Unit</option>

                                        @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" @if($product->unit_id == $unit->id)
                                            selected @endif>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Category</label>
                                <div class="form-group col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="category_id">
                                        <option selected="">Choose Category</option>

                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if($product->category_id == $category->id)
                                            selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- end row -->

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Save">
                        </form>


                    </div>
                </div>
            </div> <!-- end col -->
        </div>



    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
                supplier_id: {
                    required : true,
                },
                unit_id: {
                    required : true,
                },
                category_id: {
                    required : true,
                }
            },
            messages :{
                name: {
                    required : 'Please Enter Product Name',
                },
                supplier_id: {
                    required : 'Please Select Supplier',
                },
                unit_id: {
                    required : 'Please Select Unit',
                },
                category_id: {
                    required : 'Please Select Category',
                }
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