@extends('front.layouts.specialApp')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-11">
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar Column -->
            <div class="col-md-3">
                @include('front.account.common.specialSidebar') <!-- Include the sidebar here -->
            </div>
            <!-- Main Content Column -->
            <div class="col-md-9">
                <!-- Create Product Section -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-10">
                                <h1>Upload Book</h1>
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="products.html" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">
                        <form action="" method="post" name="bookForm" id="bookForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Main Product Creation Form -->
                                    <div class="card mb-3">
                                        <div class="card-body">								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">	
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <!-- Product Status Section -->
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="status">Book Status</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="1">Active</option>
                                                            <option value="0">Blocked</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Product Category Section -->
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="category">Book Genre</label>
                                                        <select name="category" id="category" class="form-control">
                                                            <option value="Electronics">Select a Genre</option>
                                                            @if ($categories->isNotEmpty())
                                                                 @foreach ($categories as $category)
                                                                 <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                 @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sub_category">Sub Genre</label>
                                                        <select name="sub_category" id="sub_category" class="form-control">
                                                        <option value="Electronics">Select a Sub Genre</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Featured Product Section -->
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="is_featured">Featured Book</label>
                                                        <select name="is_featured" id="is_featured" class="form-control">
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Media</h2>								
                                            <div id="image" class="dropzone dz-clickable">
                                                <div class="dz-message needsclick">    
                                                    <br>Drop files here or click to upload.<br><br>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Pricing</h2>								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="price">Price</label>
                                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">	
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="compare_price">Compare at Price</label>
                                                        <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                                        <p class="text-muted mt-3">
                                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                        </p>	
                                                    </div>
                                                </div>                                          
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Inventory</h2>								
                                            <div class="row">
                                                <!-- <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="SKU">	
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="barcode">Barcode</label>
                                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">	
                                                    </div>
                                                </div>    -->
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" checked>
                                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                                    </div>
                                                </div>                                         	                                         
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $("#title").change(function(){
        element = $(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title: element.val()},
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response["status"] == true) {
                    $("#slug").val(response["slug"]);
                }
            }
        });
    });

    $("#bookForm").submit(function(event){
        event.preventDefault();
        var formArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("account.store")}}',
            type: 'post',
            data: formArray,
            dataType: 'json',
            success: function(response) {

            },
            error: function(){
                console.log("Something Went Wrong");
            }
        });
    });

    $("#category").change(function(){
    var category_id = $(this).val();
    $.ajax({
        url: '{{ route("book-subgenres.index")}}',
        type: 'get',
        data: {category_id:category_id},
        dataType: 'json',
        success: function(response) {
            $("#sub_category").find("option").not(":first").remove();
            $.each(response["subCategories"],function(key,item){
                $("#sub_category").append(`<option ='${item.id}'>${item.name}</option>`);
            });
        },
        error: function(){
            console.log("Something Went Wrong");
        }
    });
});

</script>
@endsection
