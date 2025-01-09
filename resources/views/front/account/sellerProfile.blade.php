@extends('front.layouts.app1')

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
                <div class="col-md-12">
                    @include('front.account.common.message')
                </div>
                <div class="col-md-3">
                @include('front.account.common.sidebar')
                </div>
                <div class="col-md-9">
                <div class="card ">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <form action="" name="profileForm" id="profileForm">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="mb-3">               
                                            <label for="name">Name</label>
                                            <input value="{{ $user->name }}" type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="mb-3">            
                                            <label for="email">Email</label>
                                            <input value="{{ $user->email }}" type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="mb-3">                                    
                                            <label for="phone">Phone</label>
                                            <input value="{{ $user->phone }}" type="text" name="phone" id="phone" placeholder="Enter Your Phone" class="form-control">
                                            <p></p>
                                        </div>

                                        <!--<div class="mb-3">                                    
                                            <label for="phone">Address</label>
                                            <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address"></textarea>
                                        </div>-->

                                        <div class="d-flex">
                                            <button class="btn btn-dark">Update</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>

                    <div class="card mt-5">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Address</h2>
                        </div>
                        <form action="" name="addressForm" id="addressForm">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">               
                                            <label for="name">First Name</label>
                                            <input value="{{(!empty($address)) ? $address->first_name : '' }}" type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="col-md-6 mb-3">               
                                            <label for="name">Last Name</label>
                                            <input value="{{(!empty($address)) ? $address->last_name : '' }}" type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="col-md-6 mb-3">            
                                            <label for="email">Email</label>
                                            <input value="{{(!empty($address)) ? $address->email : '' }}" type="text" name="email" id="email" placeholder="Enter Your Email" class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="col-md-6 mb-3">                                    
                                            <label for="phone">Mobile</label>
                                            <input value="{{(!empty($address)) ? $address->mobile : '' }}" type="text" name="mobile" id="mobile" placeholder="Enter Your Mobile No." class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="mb-3">                                    
                                            <label for="phone">County</label>
                                            <select name="county_id" id="county_id" class="form-control">
                                                <option value="">Select a County</option>
                                                @if($counties->isNotEmpty())
                                                  @foreach ($counties as $county)
                                                  <option {{(!empty($address) && $address->county_id == $county->id) ? 'selected' : '' }} value="{{ $county->id }}">{{$county->name}}</option>
                                                  @endforeach
                                                @endif 
                                            </select>
                                            <p></p>
                                        </div>
                                        <div class="mb-3">                                    
                                            <label for="phone">Sub County</label>
                                            <select name="sub_county_id" id="sub_county_id" class="form-control">
                                                <option value="">Select a Sub County</option>
                                                @if($sub_counties->isNotEmpty())
                                                  @foreach ($sub_counties as $sub_county)
                                                  <option {{(!empty($address) && $address->sub_county_id == $sub_county->id) ? 'selected' : '' }} value="{{ $sub_county->id }}">{{$sub_county->name}}</option>
                                                  @endforeach
                                                @endif 
                                            </select>
                                            <p></p>
                                        </div>
                                        <div class="mb-3">                                    
                                            <label for="phone">Town</label>
                                            <select name="town_id" id="town_id" class="form-control">
                                                <option value="">Select a Town</option>
                                                @if($towns->isNotEmpty())
                                                  @foreach ($towns as $town)
                                                  <option {{(!empty($address) && $address->town_id == $town->id) ? 'selected' : '' }} value="{{ $town->id }}">{{$town->name}}</option>
                                                  @endforeach
                                                @endif 
                                            </select>
                                            <p></p>
                                        </div>
                                        <div class="mb-3 col-md-6">                                    
                                            <label for="phone">Address</label>
                                            <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{(!empty($address)) ? $address->address : '' }}</textarea>
                                            <p></p>
                                        </div>

                                        <div class="mb-3">                                    
                                            <label for="phone">Apartment</label>
                                            <input value="{{(!empty($address)) ? $address->apartment : '' }}" type="text" name="apartment" id="apartment" placeholder="Apartment" class="form-control">
                                            <p></p>
                                        </div>

                                        <!--<div class="mb-3">                                    
                                            <label for="phone">Address</label>
                                            <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Enter Your Address"></textarea>
                                        </div>-->

                                        <div class="d-flex">
                                            <button class="btn btn-dark">Update</button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>


@endsection

@section('scripts')
<script>
   

    $("#profileForm").submit(function(event){
        event.preventDefault();
        //var formArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("account.updateSellerProfile")}}',
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
            url: '{{ route("account.updateAddress")}}',
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
