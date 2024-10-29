@extends('front.layouts.app')

@section('content')
<section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/background.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/background.jpg')}}" />
                        <img src="{{ asset('front-assets/images/background.jpg')}}" alt="" style="width: 100%; height: auto; max-height: 500px;" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Study Smarter: 70% Off School Books & Resources!</h1>
                        <p class="mx-md-5 px-5">Find top-quality textbooks, reference materials, and exam prep guides all in one place. Don’t miss out on these savings for the upcoming school year!</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop Now</a>
                    </div>
                </div>

                </div>
                <div class="carousel-item">
                    
                <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/background1.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/background1.jpg')}}" />
                        <img src="{{ asset('front-assets/images/background1.jpg')}}" alt="" style="width: 100%; height: auto; max-height: 500px;"/>
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Huge Savings: 70% Off on School Books & Supplies!</h1>
                        <p class="mx-md-5 px-5">Get everything your child needs for the new school year. From textbooks to learning materials, we have you covered with incredible discounts.</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop Now</a>
                    </div>
                </div>

                </div>
                <div class="carousel-item">

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/background2.jpg')}}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/background2.jpg')}}" />
                        <img src="{{ asset('front-assets/images/background2.jpg')}}" alt="" style="width: 100%; height: auto; max-height: 500px;"/>
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Back to School: Up to 70% Off on Essential School Books!</h1>
                        <p class="mx-md-5 px-5">Prepare for success this school year with our wide selection of textbooks, workbooks, and study guides at unbeatable prices. Stock up now!</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop Now</a>
                    </div>
                </div>

                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Books</h5>
                    </div>                    
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Fast Shipping</h2>
                    </div>                    
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Returns Available</h2>
                    </div>                    
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>                    
                </div>
            </div>
        </div>
    </section>
    <section class="section-3">
        <div class="container">
            <div class="section-title">
                <h2>Categories</h2>
            </div>           
            <div class="row pb-3">
                @if (getGenres()->isNotEmpty())
                @foreach (getGenres() as $category )
                <div class="col-lg-3">
                    <div class="cat-card">
                        <div class="left">
                            @if ($category->image != "")
                            <img src="{{ asset('/uploads/category/thumb/'.$category->image) }}" alt="" class="img-fluid">
                            @endif
                            <!--<img src="{{ asset('front-assets/images/cat-1.jpg')}}" alt="" class="img-fluid"> -->
                        </div>
                        <div class="right">
                            <div class="cat-data">
                                <h2>{{$category->name}}</h2>
                                <!--<p>100 Products</p>-->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                
            </div>
        </div>
    </section>
    
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Featured Books</h2>
            </div>    
            <div class="row pb-3">
                @if($featuredBooks->isNotEmpty())
                     @foreach ($featuredBooks as $book)
                     @php
                            $bookImage = $book->book_images->first();
                     @endphp
                     <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{route('front.book',$book->slug)}}" class="product-img">

                                @if (!empty($bookImage->image))  
                                <img class="card-img-top" src="{{ asset('./uploads/book/small/'.$bookImage->image)}}" >
                                @else 
                                <img src="{{ asset('admin-assets/img/default-150x150.png')}}" />
                                @endif
                            </a>
                            <a onclick="addToWishlist({{ $book->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>                            

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
                            <a class="h6 link" href="product.php">{{ $book->title}}</a>
                            <div class="price mt-2">

                                <span class="h5"><strong>Ksh.{{ $book->price }}</strong></span>
                                @if( $book->compare_price > 0)
                                <span class="h6 text-underline"><del>Ksh.{{ $book->compare_price }}</del></span>
                                @endif
                            </div>
                        </div>                        
                    </div>                                               
                </div>
                     @endforeach

                @endif    

            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Books</h2>
            </div>    
            <div class="row pb-3">
            @if($latestBooks->isNotEmpty())
                     @foreach ($latestBooks as $book)
                     @php
                            $bookImage = $book->book_images->first();
                     @endphp
                     <div class="col-md-3">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="{{route('front.book',$book->slug)}}" class="product-img">

                                @if (!empty($bookImage->image))  
                                <img class="card-img-top" src="{{ asset('./uploads/book/small/'.$bookImage->image)}}" >
                                @else 
                                <img src="{{ asset('admin-assets/img/default-150x150.png')}}" />
                                    @endif
                            </a>
                            <a onclick="addToWishlist({{ $book->id }})" class="whishlist" href="javascript:void(0);"><i class="far fa-heart"></i></a>                            

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
                            <a class="h6 link" href="product.php">{{ $book->title}}</a>
                            <div class="price mt-2">

                                <span class="h5"><strong>Ksh.{{ $book->price }}</strong></span>
                                @if( $book->compare_price > 0)
                                <span class="h6 text-underline"><del>Ksh.{{ $book->compare_price }}</del></span>
                                @endif
                            </div>
                        </div>                        
                    </div>                                               
                </div>
                     @endforeach

                @endif              
            </div>
        </div>
    </section>
@endsection
