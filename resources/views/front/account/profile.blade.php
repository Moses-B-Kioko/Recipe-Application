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

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                @include('front.account.common.sidebar')                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">               
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                </div>
                                <div class="mb-3">            
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                </div>
                                <div class="mb-3">                                    
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                                </div>

                                <div class="mb-3">                                    
                                    <label for="phone">Address</label>
                                    <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address"></textarea>
                                </div>

                                <div class="d-flex">
                                    <button class="btn btn-dark">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
            url: '{{ route("books.store")}}',
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
