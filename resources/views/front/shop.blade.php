@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">            
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                            @if($categories->isNotEmpty())
                               @foreach ($categories as $key => $category)
                                <div class="accordion-item">
                                @if($category->sub_genre->isNotEmpty())
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key}}" aria-expanded="false" aria-controls="collapseOne-{{ $key}}">
                                            {{$category->name}}
                                        </button>
                                    </h2>
                                    @else
                                    <a href="{{ route("front.shop",$category->slug) }}" class="nav-item nav-link  {{ ($categorySelected == $category->id ? 'text-primary' : '') }}">{{$category->name}}</a>
                                    @endif
                                    @if($category->sub_genre->isNotEmpty())
                                    <div id="collapseOne-{{ $key}}" class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : '' }}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                @foreach ( $category->sub_genre as $subGenre)
                                                <a href="{{ route("front.shop",[$category->slug,$subGenre->slug]) }}" class="nav-item nav-link {{ ($subGenreSelected == $subGenre->id ? 'text-primary' : '') }}">{{$subGenre->name}}</a>
                                                @endforeach                                         
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>  
                                @endforeach
                                @endif                                          
                            </div>
                        </div>
                    </div>

                   <!-- <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Canon
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Sony
                                </label>
                            </div>                 
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Oppo
                                </label>
                            </div> 
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Vivo
                                </label>
                            </div>                 
                        </div>
                    </div> -->

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />                
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                    <option value="latest" {{ ($sort == 'latest') ? 'selected' : '' }}>Latest</option>
                                    <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : '' }}>Price High</option>
                                    <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : '' }}>Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if($books->isNotEmpty())
                            @foreach ($books as $book)
                            @php
                                    $bookImage = $book->book_images->first();
                            @endphp
                        <div class="col-md-4">
                            <div class="card product-card">
                                <div class="product-image position-relative">

                                    <a href="{{route('front.book',$book->slug)}}" class="product-img">
                                    @if (!empty($bookImage->image))  
                                        <img class="card-img-top" src="{{ asset('./uploads/book/small/'.$bookImage->image)}}" >
                                    @else 
                                        <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png')}}" />
                                    @endif
                                    </a>


                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                                    <div class="product-action">
                                @if($book->track_qty == 'Yes')
                                    @if ($book->qty > 0)
                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$book->id }});">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a> 
                                    @else
                                    <a class="btn btn-dark" href="javascript:void(0);">
                                         Out Of Stock
                                    </a> 
                                    @endif
                                       
                                @else
                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$book->id }});">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                                @endif
                            </div>
                                </div>                        
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{ $book->title }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>Ksh.{{ $book->price }}</strong></span>
                                        @if($book->compare_price > 0)
                                        <span class="h6 text-underline"><del>Ksh.{{ $book->compare_price }}</del></span>
                                        @endif
                                    </div>
                                </div>                        
                            </div>                                               
                        </div>  

                        @endforeach
                        @endif
                          

                        <div class="col-md-12 pt-5">
                            {{ $books->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

<script>
    rangerSlider = $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 1000,
        from: {{  ($priceMin) }},
        step: 10,
        to: {{  ($priceMax) }},
        skin: "round",
        max_postfix: "+",
        prefix: "ksh.",
        onFinish: function() {  
            apply_filters()
        }
    });

    //Saving it's instance to var
    var slider = $(".js-range-slider").data("ionRangeSlider");

    $("#sort").change(function(){
        apply_filters();
    });

    function apply_filters() {
    var url = '{{ url()->current() }}?';

    //Price Range filter
    url += 'price_min=' + slider.result.from + '&price_max=' + slider.result.to;

    //Sorting filter

    var keyword = $("#search").val();

    if(keyword.length > 0) {
        url += '&search='+keyword;  
    }

    url += '&sort='+$("#sort").val()
    window.location.href = url;
}



</script>

@endsection