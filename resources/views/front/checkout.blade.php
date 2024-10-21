@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form id="orderForm" name="orderForm" action="" method="post">
            
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ (!empty( $customerAdress)) ? $customerAdress->first_name : '' }}">
                                        <p></p>
                                    </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ (!empty( $customerAdress)) ? $customerAdress->last_name : '' }}">
                                        <p></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ (!empty( $customerAdress)) ? $customerAdress->email : '' }}">
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="county_id" id="county" class="form-control">
                                            <option value="">Select a County</option>
                                            @if ($counties->isNotEmpty())
                                            @foreach ( $counties as $county )
                                                  <option {{ (!empty( $customerAdress) && $customerAdress->county_id == $county->id) ? 'selected' : '' }} value="{{ $county->id }}">{{ $county->name}}</option>
                                            @endforeach

                                            @endif
                                        </select>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="sub_county_id" id="sub_county" class="form-control">
                                            <option value="">Select a Sub County</option>
                                            @if ($sub_counties->isNotEmpty())
                                            @foreach ( $sub_counties as $sub_county )
                                                  <option {{ (!empty( $customerAdress) && $customerAdress->sub_county_id == $sub_county->id) ? 'selected' : '' }} value="{{ $sub_county->id }}">{{ $sub_county->name}}</option>
                                            @endforeach

                                            @endif
                                        </select>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="town_id" id="town" class="form-control">
                                            <option value="">Select a Town</option>
                                            @if ($towns->isNotEmpty())
                                            @foreach ( $towns as $town )
                                                  <option {{ (!empty( $customerAdress) && $customerAdress->town_id == $town->id) ? 'selected' : '' }} value="{{ $town->id }}">{{ $town->name}}</option>
                                            @endforeach

                                            @endif
                                        </select>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ (!empty($customerAdress)) ? $customerAdress->address : '' }}</textarea>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ (!empty($customerAdress)) ? $customerAdress->apartment : '' }}">
                                    </div>            
                                </div>

                                <!-- <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="City">
                                    </div>            
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" class="form-control" placeholder="State">
                                    </div>            
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip">
                                    </div>            
                                </div> -->

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{ (!empty($customerAdress)) ? $customerAdress->mobile : '' }}">
                                        <p></p>
                                    </div>            
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>            
                                </div>

                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">

                            @foreach (Cart::content() as $item )
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{ $item->name}} X {{ $item->qty}}</div>
                                <div class="h6">Ksh.{{$item->price*$item->qty}}</div>
                            </div>
                            @endforeach
                            
                            
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong> Ksh.{{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong id="shippingAmount">Ksh.{{ number_format($totalShippingCharge, 2)}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grandTotal">Ksh.{{number_format($grandTotal,2)}}</strong></div>
                            </div>                            
                        </div>
                    </div>   
                    
                    <div class="card payment-form ">   

                    <h3 class="card-title h5 mb-3">Payment Method</h3>
                    <div class="">
                        <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                        <label for="payment_method_one" class="form-check-label">Cash on Delivery</label>
                    </div>

                    <div class="">
                        <input type="radio" name="payment_method" value="cod" id="payment_method_two">
                        <label for="payment_method_two" class="form-check-label">Stripe</label>
                    </div>

                    <div class="">
                        <input type="radio" name="payment_method" value="cod" id="payment_method_three">
                        <label for="payment_method_three" class="form-check-label">Mpesa</label>
                    </div>

                        <div class="card-body p-0 d-none mt-3" id="card-payment-form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                            
                        </div>    
                        <div class="pt-4">
                                <!--<a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> -->
                                <button type="Submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>                    
                    </div>

                          
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $("#payment_method_one").click(function(){
        if ($(this).is(":checked") == true) {
            $("#card-payment-form").addClass('d-none');
        }
    });

    $("#payment_method_two").click(function(){
        if ($(this).is(":checked") == true) {
            $("#card-payment-form").removeClass('d-none');
        }
    });

    $("#payment_method_three").click(function(){
        if ($(this).is(":checked") == true) {
            $("#card-payment-form").removeClass('d-none');
        }
    });
    
    $("#orderForm").submit(function(event){
        event.preventDefault();

        $('button[type="submit"]').prop('disabled',true);

        $.ajax({
            url:'{{ route("front.processCheckout" )}}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                var errors = response.errors;
                $('button[type="submit"]').prop('disabled',false);
                // front.thankyou

                if (response.status == false ) {
                    if (errors.first_name) {
                    $("#first_name").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.first_name);
                } else {
                    $("#first_name").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.last_name) {
                    $("#last_name").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.last_name);
                } else {
                    $("#last_name").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.email) {
                    $("#email").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.email);
                } else {
                    $("#email").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.county) {
                    $("#county").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.county);
                } else {
                    $("#county").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.sub_county) {
                    $("#sub_county").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.sub_county);
                } else {
                    $("#sub_county").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.town) {
                    $("#town").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.town);
                } else {
                    $("#town").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.address) {
                    $("#address").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.address);
                } else {
                    $("#address").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }

                if (errors.mobile) {
                    $("#mobile").addClass('is-invalid')
                    .siblings("p")
                    .addClass('invalid-feedback')
                    .html(errors.mobile);
                } else {
                    $("#mobile").removeClass('is-invalid')
                    .siblings("p")
                    .removeClass('invalid-feedback')
                    .html('');
                }
                } else {
                    window.location.href="{{url('/thanks/')}}/"+response.orderId;
                }

                
                
            }
        });
    });

    $("#county").change(function(){
    $.ajax({
        url: '{{ route("front.getOrderSummery") }}',
        type: 'post',
        data: {
            county_id: $(this).val()
        },
        dataType: 'json',
        success: function(response){
            if (response.status == true) { // Corrected 'respond' to 'response'
                $("#shippingAmount").html('$' + response.shippingCharge);
                $("#grandTotal").html('$' + response.grandTotal);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
});

</script>
@endsection