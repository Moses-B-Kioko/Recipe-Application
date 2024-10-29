@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">My Wishlist</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-12">
                    @include('front.account.common.message')
                </div>
                <div class="col-md-3">
                @include('front.account.common.BuyerSidebar')
                </div>
                <div class="col-md-9">
                <div class="card ">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                        </div>
                        <!--<form action="" name="profileForm" id="profileForm">-->
                                <div class="card-body p-4">
                                    @if ($wishlists->isNotEmpty())
                                        @foreach($wishlists as $wishlist)
                                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                <div class="d-block d-sm-flex align-items-start text-center text-sm-start">

                                @php
                                   $bookImage = getBookImage($wishlist->book_id)
                                @endphp
                                <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{route('front.book',$wishlist->book->slug)}}" style="width: 10rem;">
                                @if (!empty($bookImage))  
                                <img src="{{ asset('./uploads/book/small/'.$bookImage->image)}}" >
                                @else 
                                <img src="{{ asset('admin-assets/img/default-150x150.png')}}" />
                                    @endif
                                    </a>


                                    <div class="pt-2">
                                        <h3 class="product-title fs-base mb-2"><a href="shop-single-v1.html">{{ $wishlist->book->title }}</a></h3>                                        
                                        <div class="fs-lg text-accent pt-2">
                                        <span class="h5"><strong>Ksh.{{ $wishlist->book->price }}</strong></span>
                                        @if( $wishlist->book->compare_price > 0)
                                        <span class="h6 text-underline"><del>Ksh.{{ $wishlist->book->compare_price }}</del></span>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                    <button onclick="removeBook({{ $wishlist->book_id }});" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                </div>
                            </div>
                                        @endforeach
                                        @else

                                        <div>
                                            <h3 class="h5">Your wishlist is empty!!</h3>
                                        </div>
                                    @endif
                               
                                </div>
                        <!--</form>-->
                    </div>

                    <!--<div class="card mt-5">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Address</h2>
                        </div>
                        <form action="" name="addressForm" id="addressForm">
                                <div class="card-body p-4">
                                   
                                </div>
                        </form>
                    </div>-->
                    
                    
                </div>
            </div>
        </div>
    </section>


@endsection

@section('scripts')
<script>
    function removeBook(id) {
        $.ajax({
            url: '{{ route("account.removeBookFromWishlist")}}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if(response.status == true) {
                    window.location.href = "{{ route('account.wishlist')}}";
                } 
            }
        });
    }
   

    $("#profileForm").submit(function(event){
        event.preventDefault();
        //var formArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("account.updateBuyerProfile")}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status == true ) {
                    $("#profileForm #name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#profileForm #email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#profileForm #phone").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');

                    window.location.href = '{{ route("account.sellerProfile") }}';


                } else {
                    var errors = response.errors;
                    if(errors.name) {
                        $("#profileForm #name").addClass('is-invalid').siblings('p').html(errors.name).addClass('invalid-feedback');
                    } else {
                        $("#profileForm #name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.email) {
                        $("#profileForm #email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    } else {
                        $("#profileForm #email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }   
                    if(errors.phone) {
                        $("#profileForm #phone").addClass('is-invalid').siblings('p').html(errors.phone).addClass('invalid-feedback');
                    } else {
                        $("#profileForm #phone").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                }
            },
            error: function(){
                console.log("Something Went Wrong");
            }
        });
    });


    $("#addressForm").submit(function(event){
        event.preventDefault();
        //var formArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("account.updateBuyerAddress")}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status == true ) {
                    $("#name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    $("#phone").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');

                    window.location.href = '{{ route("account.sellerProfile") }}';


                } else {
                    var errors = response.errors;
                    if(errors.first_name) {
                        $("#first_name").addClass('is-invalid').siblings('p').html(errors.first_name).addClass('invalid-feedback');
                    } else {
                        $("#first_name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.last_name) {
                        $("#last_name").addClass('is-invalid').siblings('p').html(errors.last_name).addClass('invalid-feedback');
                    } else {
                        $("#last_name").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }  
                    if(errors.email) {
                        $("#addressForm #email").addClass('is-invalid').siblings('p').html(errors.email).addClass('invalid-feedback');
                    } else {
                        $("#addressForm #email").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    } 
                    if(errors.mobile) {
                        $("#mobile").addClass('is-invalid').siblings('p').html(errors.mobile).addClass('invalid-feedback');
                    } else {
                        $("#mobile").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.county_id) {
                        $("#county_id").addClass('is-invalid').siblings('p').html(errors.county_id).addClass('invalid-feedback');
                    } else {
                        $("#county_id").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.sub_county_id) {
                        $("#sub_county_id").addClass('is-invalid').siblings('p').html(errors.sub_county_id).addClass('invalid-feedback');
                    } else {
                        $("#sub_county_id").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.town_id) {
                        $("#town_id").addClass('is-invalid').siblings('p').html(errors.town_id).addClass('invalid-feedback');
                    } else {
                        $("#town_id").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.address) {
                        $("#address").addClass('is-invalid').siblings('p').html(errors.address).addClass('invalid-feedback');
                    } else {
                        $("#address").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                    if(errors.apartment) {
                        $("#apartment").addClass('is-invalid').siblings('p').html(errors.apartment).addClass('invalid-feedback');
                    } else {
                        $("#apartment").removeClass('is-invalid').siblings('p').html('').removeClass('invalid-feedback');
                    }
                }
            },
            error: function(){
                console.log("Something Went Wrong");
            }
        });
    });


</script>
@endsection
