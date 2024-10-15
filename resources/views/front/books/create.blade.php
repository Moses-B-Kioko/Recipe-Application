@extends('front.layouts.app')

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
                @include('front.account.common.sidebar') <!-- Include the sidebar here -->
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
                                <a href="{{ route('books.index')}}" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                <form action="" method="post" name="bookForm" id="bookForm">
                @csrf   
                <div class="container-fluid">
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
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="slug">Slug</label>
                                                        <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="author">Author</label>
                                                        <input type="author" name="author" id="author" class="form-control" placeholder="Author">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description">Short Description</label>
                                                        <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" placeholder="Short Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                                    </div>
                                                </div><div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description">Shipping and Returns</label>
                                                        <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" placeholder="Shipping and Returns"></textarea>
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
                                                            <option value="">Select a Genre</option>
                                                           @if ($categories->isNotEmpty())
                                                           @foreach ($categories as $category)
                                                           <option value="{{$category->id}}">{{$category->name}}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                        <p class="error"></p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sub_category">Sub Genre</label>
                                                        <select name="sub_category" id="sub_category" class="form-control">
                                                        <option value="Electronics">Select a Sub Genre</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="condition">Condition of Book</label>
                                                        <select name="condition" id="condition" class="form-control">
                                                        <option value="Perfect">Perfect</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Okay">Okay</option>
                                                        <option value="Not that Okay">Not that Okay</option>
                                                        <option value="Bad">Bad</option>
                                                        </select>
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <!-- Featured Product Section -->
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="is_featured">Featured Book</label>
                                                        <select name="is_featured" id="is_featured" class="form-control">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Image</h2>								
                                            <div id="image" class="dropzone dz-clickable">
                                                <div class="dz-message needsclick">    
                                                    <br>Drop files here or click to upload.<br><br>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="product-gallery">

                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Pricing</h2>								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="price">Price</label>
                                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">	
                                                        <p class="error"></p>
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
                                                            <input type="hidden" name="track_qty" value="No">
                                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>
                                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                            <p class="error"></p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>                                         	                                         
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                             <div class="col-md-12">
                                                    <div class="mb-3">
                                                    <h2 class="h4 mb-3">Related Book</h2>								
                                                    <select multiple class="related-book w-100" name="related_books[]" id="related_books">
                                                        </select>
                                                        <p class="error"></p>
                                                    </div>
                                                </div> 
                                            </div> 
                                        </div> 
                                </div>
                            </div>

                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route('books.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
        

        <script>
 // Function to convert the name to a slug
 function generateSlug(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }

    // Automatically update the slug field when the name field is changed
    $('#title').on('keyup', function() {
        var name = $(this).val();
        var slug = generateSlug(name);
        $('#slug').val(slug);  // Assign the generated slug to the slug input field
    });


            $('.related-book').select2({
            ajax: {
                url: '{{ route("books.getBooks") }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });


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

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                        $("#bookForm").submit(function(event){
                        event.preventDefault();
                        var formArray = $(this).serializeArray();
                        $("button[type='submit']").prop('disabled',true);

                        $.ajax({
                            url: '{{ route("books.store")}}',
                            type: 'post',
                            data: formArray,
                            dataType: 'json',
                            success: function(response) {
                                $("button[type='submit']").prop('disabled',false);

                                if (response['status'] == true) {
                                    $(".error").removeClass('invalid-feedback').html('');
                                    $("input[type= 'text'], select, input[type= 'number']").removeClass('is-invalid');

                                    window.location.href ="{{ route('books.index')}}";
                                } else {
                                    var errors = response['errors'];

                                    $(".error").removeClass('invalid-feedback').html('');
                                    $("input[type= 'text'], select, input[type= 'number']").removeClass('is-invalid');

                                    $.each(errors, function(key,value){
                                        $('#' + key).addClass('is-invalid')
                                        .siblings('p')
                                        .addClass('invalid-feedback')
                                        .html(value);

                                    });
                                }
                            },
                            error: function(){
                                console.log("Something Went Wrong");
                            }
                        });
                    });


                    $("#category").change(function(){
                var category_id = $(this).val();
                console.log('Selected Category ID:', category_id); // Log the selected ID

                $.ajax({
                    url: '{{ route("book-subgenres.index") }}',
                    type: 'get',
                    data: { category_id: category_id },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Sub-Genres Response:', response); // Log the server response
                        $("#sub_category").find("option").not(":first").remove();
                        $.each(response.subGenres, function(key, item) {
                            $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`);
                        });
                    },
                    error: function(xhr) {
                        console.log("Error:", xhr); // Log the error response
                    }
                });
        });

        Dropzone.autoDiscover = false;
const dropzone = $("#image").dropzone({
    url: "{{ route('temp-images.create') }}",
    maxFiles: 10,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        console.log('Image Path:', response.ImagePath); // Log the image path
        if (response.image_id) {
            var html = `
                <div class="col-md-3" id="image-row-${response.image_id}">
                    <div class="card">
                        <input type="hidden" name="image_array[]" value="${response.image_id}">
                        <img src="${response.ImagePath}" class="card-img-top" alt="Uploaded Image">
                        <div class="card-body">
                            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            `;
            $("#product-gallery").append(html);
        } else {
            console.log("No image_id received from the server.");
            alert("File uploaded but no image ID received.");
        }
    },
    complete: function(file) {
        // Ensure that the file is removed after being successfully uploaded
        if (file.status === "success") {
            this.removeFile(file);
        }
    },
    error: function(file, errorMessage) {
        console.log("File upload error:", errorMessage);
        alert("An error occurred while uploading the file.");
    }
});

// Function to handle image deletion
function deleteImage(id) {
    $("#image-row-" + id).remove();  // Include the hyphen to match the id
}

        </script>
        
@endsection