@extends('front_end.layout.layout')
@section('content')
@section('css')

@endsection
<!-- <div class="snowflakes" aria-hidden="true">
  <div class="snowflake">❅</div>
  <div class="snowflake">❆</div>
  <div class="snowflake">❅</div>
  <div class="snowflake">❆</div>
  <div class="snowflake">❅</div>
  <div class="snowflake">❆</div>
  <div class="snowflake">❅</div>
  <div class="snowflake">❆</div>
  <div class="snowflake">❅</div>
  <div class="snowflake">❆</div>
  <div class="snowflake">❅</div>
  <div class="snowflake">❆</div>
</div> -->
<div class="slider-area" style="margin-top: 10px;">
    <!-- Slider bxslider-home4 -->

    <div class="block-slider block-slider4">
        <ul class="" id="bxslider-home4">
            @foreach($products['slides'] as $slide)
            <li class="row">
                <div class="col-md-3 caption-group">
                    <h3 class="caption title">
                        <span class="primary">{{$slide->title}}</span>
                    </h3>
                    <a class="caption button-radius" href="#"><span class="icon"></span>Xem ngay</a>
                </div>
                <div class="col-md-8">
                    <img src="{{$slide->image}}" alt="Slide" height="2000px">
                </div>

            </li>
            @endforeach
        </ul>
    </div>
    <!-- ./Slider -->
</div> <!-- End slider area -->

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <div class="single-sidebar">
                        <h2 class="sidebar"> Sản phẩm mới nhất</h2>
                    </div>
                    <div class="product-carousel">
                        @foreach($products['newProducts'] as $product)
                        <div class="single-product">
                            <div style="height: 220px;" class="product-f-image">
                                <img src="{{$product->image}}" alt="">
                                <div class="product-hover">
                                    <a href="#" class="add-to-cart-link"><i class="fa fa-plus-square"></i> chọn mua</a>
                                    <a href="{{route('detail',$product->id)}}" class="view-details-link"><i class="fa fa-link"></i> chi tiết</a>
                                </div>
                            </div>

                            <h2 style="height: 40px;"><a href="{{route('detail',$product->id)}}">{{$product->name}}</a></h2>

                            <div class="product-carousel-price text-center" style="font-size: 14px;">
                                @if($product->promotion_price==0)
                                <ins style="color: #bf081f;">{{number_format($product->unit_price)}} đ</ins>
                                @else
                                <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del>{{number_format($product->unit_price)}} đ</del>
                                @endif
                            </div>
                            <div class="rating-wrap-post" style="font-size: 14px; margin-top: 5px;">
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="cdt-product__config__param" style="margin-top: 5px;">
                                <span title="CPU"><i class="fas fa-microchip"></i> {{$product->specifications['cpu']}}</span>
                                <span style="margin-left: 5px;" title="Ram"><i class="fas fa-microchip"></i> {{$product->specifications['ram']}}</span>
                                <span style="margin-left: 5px;" title="Bộ nhớ"><i class="fas fa-hdd"></i> {{$product->specifications['rom_harddrive']}}</span>
                                <span style="margin-left: 5px;" title="Màn hình"><i class="fas fa-tv"></i> {{$product->specifications['displayscreen']}}</span>
                            </div>

                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
        <div style="height: 30px; background-color: #f0f1f5;"></div>
    </div>
</div> <!-- End main content area -->

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <div class="single-sidebar">
                        <h2 class="sidebar"> Điện thoại</h2>
                    </div>
                    <div class="product-carousel">
                        @foreach($products['phoneProducts'] as $product)
                        <div class="single-product">
                            <div style="height: 220px;" class="product-f-image">
                                <img src="{{$product->image}}" alt="">
                                <div class="product-hover">
                                    <a href="#" class="add-to-cart-link"><i class="fa fa-plus-square"></i> Giỏ hàng</a>
                                    <a href="{{route('detail',$product->id)}}" class="view-details-link"><i class="fa fa-link"></i> chi tiết</a>
                                </div>
                            </div>

                            <h2 style="height: 40px;"><a href="{{route('detail',$product->id)}}">{{$product->name}}</a></h2>

                            <div class="product-carousel-price text-center" style="font-size: 14px;">
                                @if($product->promotion_price==0)
                                <ins style="color: #bf081f;">{{number_format($product->unit_price)}} đ</ins>
                                @else
                                <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del>{{number_format($product->unit_price)}} đ</del>
                                @endif
                            </div>
                            <div class="rating-wrap-post" style="font-size: 14px; margin-top: 5px;">
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="cdt-product__config__param" style="margin-top: 5px;">
                                <span title="CPU"><i class="fas fa-microchip"></i> {{$product->specifications['cpu']}}</span>
                                <span style="margin-left: 5px;" title="Ram"><i class="fas fa-microchip"></i> {{$product->specifications['ram']}}</span>
                                <span style="margin-left: 5px;" title="Bộ nhớ"><i class="fas fa-hdd"></i> {{$product->specifications['rom_harddrive']}}</span>
                                <span style="margin-left: 5px;" title="Màn hình"><i class="fas fa-tv"></i> {{$product->specifications['displayscreen']}}</span>
                            </div>

                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
        <div style="height: 30px; background-color: #f0f1f5;"></div>
    </div>
</div> <!-- End main content area -->

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <div class="single-sidebar">
                        <h2 class="sidebar"> Laptop</h2>
                    </div>
                    <div class="product-carousel">
                        @foreach($products['laptopProducts'] as $product)
                        <div class="single-product">
                            <div style="height: 220px;" class="product-f-image">
                                <img src="{{$product->image}}" alt="">
                                <div class="product-hover">
                                    <a href="#" class="add-to-cart-link"><i class="fa fa-plus-square"></i> Giỏ hàng</a>
                                    <a href="{{route('detail',$product->id)}}" class="view-details-link"><i class="fa fa-link"></i> chi tiết</a>
                                </div>
                            </div>

                            <h2 style="height: 40px;"><a href="{{route('detail',$product->id)}}">{{$product->name}}</a></h2>

                            <div class="product-carousel-price text-center" style="font-size: 14px;">
                                @if($product->promotion_price==0)
                                <ins style="color: #bf081f;">{{number_format($product->unit_price)}} đ</ins>
                                @else
                                <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del>{{number_format($product->unit_price)}} đ</del>
                                @endif
                            </div>
                            <div class="rating-wrap-post" style="font-size: 14px; margin-top: 5px;">
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="cdt-product__config__param" style="margin-top: 5px;">
                                <span title="CPU"><i class="fas fa-microchip"></i> {{$product->specifications['cpu']}}</span>
                                <span style="margin-left: 5px;" title="Ram"><i class="fas fa-microchip"></i> {{$product->specifications['ram']}}</span>
                                <span style="margin-left: 5px;" title="Bộ nhớ"><i class="fas fa-hdd"></i> {{$product->specifications['rom_harddrive']}}</span>
                                <span style="margin-left: 5px;" title="Màn hình"><i class="fas fa-tv"></i> {{$product->specifications['displayscreen']}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div style="height: 30px; background-color: #f0f1f5;"></div>
    </div>
</div> <!-- End main content area -->

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <div class="single-sidebar">
                        <h2 class="sidebar"> Tablet</h2>
                    </div>
                    <div class="product-carousel">
                        @foreach($products['tabletProducts'] as $product)
                        <div class="single-product">
                            <div style="height: 220px;" class="product-f-image">
                                <img src="{{$product->image}}" alt="">
                                <div class="product-hover">
                                    <a href="#" class="add-to-cart-link"><i class="fa fa-plus-square"></i> Giỏ hàng</a>
                                    <a href="{{route('detail',$product->id)}}" class="view-details-link"><i class="fa fa-link"></i> chi tiết</a>
                                </div>
                            </div>

                            <h2 style="height: 40px;"><a href="{{route('detail',$product->id)}}">{{$product->name}}</a></h2>

                            <div class="product-carousel-price text-center" style="font-size: 14px;">
                                @if($product->promotion_price==0)
                                <ins style="color: #bf081f;">{{number_format($product->unit_price)}} đ</ins>
                                @else
                                <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del>{{number_format($product->unit_price)}} đ</del>
                                @endif
                            </div>
                            <div class="rating-wrap-post" style="font-size: 14px; margin-top: 5px;">
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="cdt-product__config__param" style="margin-top: 5px;">
                                <span title="CPU"><i class="fas fa-microchip"></i> {{$product->specifications['cpu']}}</span>
                                <span style="margin-left: 5px;" title="Ram"><i class="fas fa-microchip"></i> {{$product->specifications['ram']}}</span>
                                <span style="margin-left: 5px;" title="Bộ nhớ"><i class="fas fa-hdd"></i> {{$product->specifications['rom_harddrive']}}</span>
                                <span style="margin-left: 5px;" title="Màn hình"><i class="fas fa-tv"></i> {{$product->specifications['displayscreen']}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div style="height: 30px; background-color: #f0f1f5;"></div>
    </div>
</div> <!-- End main content area -->

@endsection

@section('js')

@endsection