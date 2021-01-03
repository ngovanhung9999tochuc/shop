@extends('front_end.layout.layout')
@section('content')
@section('css')

@endsection

<div class="single-product-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-content-right">
                    <div class="product-breadcroumb">
                        <h2 class="">{{$productType->name}} {{$product->name}}</h2>
                    </div>

                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="product-images text-center">
                                <div class="product-main-img">
                                    <img id="main-image" src="{{$product->image}}" alt="" height="400px" width="400px">
                                </div>
                                <div class="product-gallery">
                                    <img class="image-gallery" src="{{$product->image}}" alt="">
                                    @foreach($productImage as $image)
                                    <img class="image-gallery" src="{{$image->image}}" alt="">
                                    @endforeach
                                </div>
                                <div class="related-products-wrapper" style="margin-top: 50px;">
                                    <h2 class="related-products-title text-left">Sản phẩm tương tự</h2>
                                    <div class="related-products-carousel">
                                        @foreach($similarProduct as $similarproduct)
                                        <div class="single-product">
                                            <div style="width: 180px;height: 220px;" class="product-f-image">
                                                <img src="{{$similarproduct->image}}" alt="">
                                                <div class="product-hover">
                                                    <a id="item-cart-{{$similarproduct->id}}" class="add-product-to-cart add-to-cart-link"><i class="fa fa-plus-square"></i> chọn mua</a>
                                                    <a href="{{route('detail',$similarproduct->id)}}" class="view-details-link"><i class="fa fa-link"></i> chi tiết</a>
                                                </div>
                                            </div>
                                            <h2><a href="{{route('detail',$similarproduct->id)}}">{{$similarproduct->name}}</a></h2>
                                            <div class="product-carousel-price text-center" style="font-size: 14px;">
                                                @if($similarproduct->promotion_price==0)
                                                <ins style="color: #bf081f;">{{number_format($similarproduct->unit_price)}} đ</ins>
                                                @else
                                                <ins style="color: #bf081f;">{{number_format($similarproduct->unit_price - $similarproduct->unit_price*$similarproduct->promotion_price/100)}} đ</ins> <del>{{number_format($similarproduct->unit_price)}} đ</del>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="product-inner">
                                <h3 class="product-name">{{$product->name}}</h3>
                                <div class="product-inner-price" style="font-size: 16px;">
                                    @if($product->promotion_price==0)
                                    <ins style="color: #bf081f;">{{number_format($product->unit_price)}} đ</ins>
                                    @else
                                    <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del>{{number_format($product->unit_price)}} đ</del>
                                    @endif
                                </div>

                                <div class="cart" style="margin-bottom: 40px;">
                                    <button id="item-cart-{{$product->id}}" class="add-product-to-cart add_to_cart_button" style="padding: 5px 20px;"><i class="fa fa-plus-square"></i> CHỌN MUA</button>
                                </div>

                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Miêu tả</a></li>
                                        <li role="presentation"><a href="#details" aria-controls="home" role="tab" data-toggle="tab">Thông số</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Đánh giá</a></li>
                                        <li role="presentation"><a href="#comment" aria-controls="profile" role="tab" data-toggle="tab">Bình Luận</a></li>

                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            {!! $product->description !!}
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="profile">
                                            <h2>Reviews</h2>
                                            <div class="submit-review">
                                                <p><label for="name">Name</label> <input name="name" type="text"></p>
                                                <p><label for="email">Email</label> <input name="email" type="email"></p>
                                                <div class="rating-chooser">
                                                    <p>Your rating</p>

                                                    <div class="rating-wrap-post">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
                                                <p><input type="submit" value="Submit"></p>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="details">
                                            {!! $product->specifications_all !!}
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade" id="comment">

                                        </div>
                                    </div>

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

@section('js')
<script>
    const imageGallery = document.querySelectorAll('.image-gallery');
    const mainImage = document.getElementById('main-image');
    imageGallery.forEach(function(image) {
        image.addEventListener('click', function() {
            mainImage.src = image.src;
            mainImage.style.width = '400px';
        });
    });
</script>
@endsection