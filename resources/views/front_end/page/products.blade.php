@extends('front_end.layout.layout')
@section('content')
@section('css')
@endsection


<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>{{$title}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="single-product-area">

    <div class="container">
        <div class="brands-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="brand-wrapper">
                            <div class="brand-list">
                                @foreach($productTypes as $productType)
                                <a href="{{route('type.type',$productType->id)}}"><img style="width: 200px; height: 80px;" src="{{$productType->icon}}" alt=""></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin:  20px 0px 20px -30px; width: 1170px; height: 30px; background-color: #f0f1f5;">
                </div>
                <div class="row" >
                    @foreach ($products as $product)
                    <div class="col-md-3 col-sm-6" style="height: 550px;">
                        <div class="single-shop-product">
                            <a href="{{route('detail',$product->id)}}">
                                <div class="product-upper">
                                    <img style="height: 220px; width: 220;" src="{{$product->image}}" alt="">
                                </div>
                                <h2 style="height: 40px;">{{$product->name}}</h2>
                            </a>

                            <div class="product-carousel-price" style="font-size: 14px;">
                                @if($product->promotion_price==0)
                                <ins style="color: #bf081f;">{{number_format($product->unit_price)}} đ</ins>
                                @else
                                <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del style="color: black;">{{number_format($product->unit_price)}} đ</del>
                                @endif
                            </div>
                            <div class="rating-wrap-post" style="font-size:  14px;color: black; margin-top: 5px;">
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i style="color: yellow;" class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="product-option-shop">
                                <a id="item-cart-{{$product->id}}" class="add-product-to-cart add_to_cart_button"  rel="nofollow"><i class="fa fa-plus-square"></i> chọn mua</a>
                            </div>
                            <div class="cdt-product__config__param" style="margin-top: 5px; color: black; ">
                                <span style="margin-left: 5px;" title="CPU"><i class="fas fa-microchip" ></i> {{$product->specifications['cpu']}}</span><br />
                                <span style="margin-left: 5px;" title="Ram"><i class="fas fa-microchip"></i> {{$product->specifications['ram']}}</span><br />
                                <span style="margin-left: 5px;" title="Bộ nhớ"><i class="fas fa-hdd"></i> {{$product->specifications['rom_harddrive']}}</span><br />
                                <span style="margin-left: 5px;" title="Màn hình"><i class="fas fa-tv"></i> {{$product->specifications['displayscreen']}}</span><br />
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    {{$products->links()}}
                </div>
            </div>
        </div> <!-- End brands area -->



    </div>
</div>





@endsection

@section('js')

@endsection