@extends('front.layouts.app')

@section('content')
<div class="app-content">
    <div class="u-s-p-y-60">
        <div class="Section_content">
            <div class="container">
                <div class="breadcrumb">
                    <div class="breadcrumb__wrap">
                        <ul class="breadcrumb__list">
                            <li class="has-separator">
                                <a href="index.html">Home</a></li>
                            <li class= "is-marked">
                                <a href="#">Payment</a>
                            </li>    
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!--Section 2-->
<div class="u-s-p-y-60">
    <div class="Section_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about">
                        <div class="about__container">
                            <div class="about__info">
                                <h2 class="about__h2"> YOUR ORDER HAS BEEN PLACED
                                    SUCCESSFULLY!
                                </h2>
                                <div class="about_p-wrap">
                                    <p class="about__p"> Your Order ID is {{
                                        Session::get('order_id')}} and Grand Total is INR {{Session::get('grand_total')}}
                                    </p>
                                    <p>
                                        Please make payment to confirm your Order
                                    </p>
                                    <p>
                                        <form action="{{ url('/account/pay') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="amount" value="{{round(Session::get('grand_total')/130,2)}}">
                                            <input type="image" src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" alt="Pay Now">
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection