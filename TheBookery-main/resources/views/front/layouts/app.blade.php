<!DOCTYPE html>
<html class="no-js" lang="en_AU">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>The Bookery</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css')}}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">



    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
    <!-- Display error messages if any -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-light top-header">        
    <div class="container">
        <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
            <div class="col-lg-4 logo">
                <a href="{{route('front.home')}}" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">THE</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">BOOKERY</span>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
    @if (Auth::check())
        <!-- Check the user's type -->
        @php
            $user = Auth::user();
        @endphp

        @if ($user->role == 1) 
            <!-- Seller-specific links -->
            <a href="{{ route('account.sellerProfile') }}" class="nav-link text-dark">Seller Dashboard</a>
        @elseif ($user->role == 3) 
            <!-- Buyer-specific links -->
            <a href="{{ route('account.profile') }}" class="nav-link text-dark">My Account</a>
        @else 
            <!-- General fallback for other user roles -->
            <a href="{{ route('account.profile') }}" class="nav-link text-dark">My Account</a>
        @endif
    @else
        <!-- For guests -->
        <a href="{{ route('account.login') }}" class="nav-link text-dark">Login/Register</a>
    @endif
                <form action="{{ route('front.shop')}}">                    
                    <div class="input-group">
                        <input value="{{Request::get('search')}}" type="text" placeholder="Search For Products" class="form-control" name="search" id="search">
                        <button type="submit" class="input-group-text">
                            <i class="fa fa-search"></i>
</button>
                    </div>
                </form>
            </div>		
        </div>
    </div>
</div>

<header class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-xl" id="navbar">
            <a href="{{ route('front.home')}}" class="text-decoration-none mobile-logo">
                <span class="h2 text-uppercase text-primary bg-dark">THE</span>
                <span class="h2 text-uppercase text-white px-2">BOOKERY</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="navbar-toggler-icon fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if(getGenres()->isNotEmpty())
                    @foreach (getGenres() as $category)
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $category->name }}
                        </button>
                        @if($category->sub_genre->isNotEmpty())
                        <ul class="dropdown-menu dropdown-menu-dark">
                        @foreach ($category->sub_genre as $subGenres)
                        <li><a class="dropdown-item nav-link" href="{{ route('front.shop',[$category->slug, $subGenres->slug]) }}">{{$subGenres->name}}</a></li>
                        @endforeach
                        </ul>
                        @endif 
                    </li>
                    @endforeach
                    @endif
                </ul>      			
            </div>   
            <div class="right-nav py-0 d-flex align-items-center">
                <a href="{{ route('front.cart')}}" class="ml-3 d-flex pt-2">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </a>
                @if (Auth::check())
                <a href="{{ route('account.sellerProfile') }}" class="btn btn-warning" style="background-color: yellow; color: black; margin-left: 30px;">Sell</a>
            @else
                <a href="{{ route('account.register') }}" class="btn btn-warning" style="background-color: yellow; color: black; margin-left: 30px;">Sell</a>
            @endif
            </div>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="bg-dark mt-5">
    <div class="container pb-5 pt-3">
        <div class="row">
            <div class="col-md-4">
            <div class="footer-card">
            <h3>Get In Touch</h3>
            <p>We'd love to hear from you! Whether you have questions about our books, want to give feedback, or need support, feel free to reach out. <br>
             Nairobi, Kenya <br>
            Email: thebookery@gmail.com <br>
            Phone: 0743996189</p>
        </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>Important Links</h3>
                    <ul>
                        @if (staticPages()->isNotEmpty())
                           @foreach (staticPages() as $page)
                           <li><a href="{{ route('front.page',$page->slug) }}" title="{{$page->name}}">{{$page->name}}</a></li>
                           @endforeach
                        @endif
                        <!---us.php" title="About">About</a></li>
                        <li><a href="contact-us.php" title="Contact Us">Contact Us</a></li>						
                        <li><a href="#" title="Privacy">Privacy</a></li>
                        <li><a href="#" title="Privacy">Terms & Conditions</a></li>
                        <li><a href="#" title="Privacy">Refund Policy</a></li>-->
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="footer-card">
                    <h3>My Account</h3>
                    <ul>
                        <li><a href="{{ route('account.login')}}" title="Sell">Login</a></li>
                        <li><a href="{{ route('account.register')}}" title="Advertise">Register</a></li>
                        <!--<li><a href="#" title="Contact Us">My Orders</a></li>-->						
                    </ul>
                </div>
            </div>			
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="copy-right text-center">
                        <p>© Copyright 2024 The Bookery. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Wishlist Modal -->
<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Success</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Load jQuery only once -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{ asset('front-assets/js/slick.min.js')}}"></script>
<script src="{{ asset('front-assets/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{ asset('front-assets/js/custom.js')}}"></script>

<!-- AdminLTE Plugins -->
<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('admin-assets/js/adminlte.min.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.js')}}"></script>
<script src="{{ asset('admin-assets/js/demo.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>



<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky");
  } else {
    navbar.classList.remove("sticky");
  }
}

$(document).ready(function(){
    $(".summernote").summernote(); // Ensure you have a textarea with class 'summernote'
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addToCart(id) {
        $.ajax({
            url: '{{ route("front.addToCart")}}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if(response.status == true) {
                    window.location.href = "{{ route('front.cart')}}";
                } else {
                    alert(response.message);
                }
            }
        });
    }

    function addToWishlist(id) {
        $.ajax({
            url: '{{ route("front.addToWishlist")}}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                if(response.status == true) {
                    $("#wishlistModal .modal-body").html(response.message);
                    $("#wishlistModal").modal('show');
                } else {
                    window.location.href = "{{ route('account.login')}}";
                    //alert(response.message);
                }
            }
        });
    }

   
</script>
@yield('scripts')
</body>
</html>
