@extends('front_end.layout.layout')
@section('content')
@section('css')
<style>
    .rating1 {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }

    .rating1>input {
        display: none
    }

    .rating1>label {
        position: relative;
        width: 1em;
        font-size: 36px;
        color: #FFD600;
        cursor: pointer
    }

    .rating1>label::before {
        content: "\2605";
        position: absolute;
        opacity: 0
    }

    .rating1>label:hover:before,
    .rating1>label:hover~label:before {
        opacity: 1 !important
    }

    .rating1>input:checked~label:before {
        opacity: 1
    }

    .rating1:hover>input:checked~label:before {
        opacity: 0.4
    }
</style>
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
                                                    <a id="item-cart-{{$similarproduct->id}}" onclick="addItemCart(this)" class="add-product-to-cart add-to-cart-link"><i class="fa fa-plus-square"></i> chọn mua</a>
                                                    <a href="{{route('detail',$similarproduct->id)}}" class="view-details-link"><i class="fa fa-link"></i> chi tiết</a>
                                                </div>
                                            </div>
                                            <h2><a href="{{route('detail',$similarproduct->id)}}">{{$similarproduct->name}}</a></h2>
                                            <div class="product-carousel-price text-center" style="font-size: 14px;">
                                                @if($similarproduct->promotion_price==0)
                                                <ins style="color: #bf081f;">{{number_format($similarproduct->unit_price)}} đ</ins>
                                                @else
                                                <ins style="color: #bf081f;">{{number_format($similarproduct->unit_price - $similarproduct->unit_price*$similarproduct->promotion_price/100)}} đ</ins> <del>{{number_format($similarproduct->unit_price)}} đ</del><span style="margin-left: 5px; color: #d0021b;">-{{$product->promotion_price}}%</span>
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
                                    <ins style="color: #bf081f;">{{number_format($product->unit_price - $product->unit_price*$product->promotion_price/100)}} đ</ins> <del>{{number_format($product->unit_price)}} đ</del><span style="margin-left: 5px; color: #d0021b;">-{{$product->promotion_price}}%</span>
                                    @endif
                                </div>
                                <div class="cart" style="margin-bottom: 10px;font-size: 16px;">
                                @php
                                if($product->userReview!=null){
                                $average = (float) $product->userReview->average;
                                echo number_format($average, 1, '.', ',').'<i style="color: yellow;" class="fa fa-star"></i>';
                                } 
                                @endphp
                                </div>
                                <div class="cart" style="margin-bottom: 40px;">
                                    <button id="item-cart-{{$product->id}}" onclick="addItemCart(this)" class="add-product-to-cart add_to_cart_button" style="padding: 5px 20px;"><i class="fa fa-plus-square"></i> CHỌN MUA</button>
                                </div>

                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Đánh giá</a></li>
                                        <li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Miêu tả</a></li>
                                        <li role="presentation"><a href="#details" aria-controls="home" role="tab" data-toggle="tab">Thông số</a></li>

                                        <!--   <li role="presentation"><a href="#comment" aria-controls="profile" role="tab" data-toggle="tab">Bình Luận</a></li> -->

                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade " id="home">
                                            {!! $product->description !!}
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade in active" id="profile">
                                            <div>
                                                @foreach($user_ratings as $user_rating)
                                                <div class="card">
                                                    <div style="font-size: 14px; font-weight: bold; background-color: #F2F2F2;" class="card-header">
                                                        {{$user_rating->name}}
                                                    </div>
                                                    <div class="card-body" style="margin-top: 10px;">
                                                        <h5 class="card-title">
                                                            @php
                                                            $stars = (int) $user_rating->pivot->stars;
                                                            $i = 1;
                                                            while ($i <= $stars) { echo '<i style="color: yellow;" class="fa fa-star"></i>' ; $i++; }
                                                            while ($i <=5) { echo '<i class="fa fa-star"></i>' ; $i++; }; @endphp <span style="margin-left: 10px;">{{$user_rating->pivot->created_at->format('d/m/Y')}}</span>
                                                        </h5>
                                                        <p class="card-text">{{$user_rating->pivot->text_rating}}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                {{ $user_ratings->links() }}
                                            </div>

                                            <h2 style="margin-top: 30px; font-size: 18px; font-weight: bold;text-align: center;">Đánh giá</h2>
                                            <div class="submit-review">
                                                <form method="POST" action="{{route('detail.rating')}}">
                                                    @csrf
                                                    @if(Auth::check())
                                                    <input name="id" class="form-control" type="hidden" value="{{Auth::user()->id}}">
                                                    @else
                                                    <p><label>Tài khoản:</label> <input style="border-radius: 5px;" name="email" class="@error('email') is-invalid @enderror" value="{{old('email')}}" type="email"></p>
                                                    @error('email')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <p><label>Mật khẩu:</label> <input style="border-radius: 5px;" class="@error('password') is-invalid @enderror" name="password" type="password"></p>
                                                    @error('password')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    @endif
                                                    <div class="rating-chooser">
                                                        <input name="product_id" class="form-control" type="hidden" value="{{$product->id}}">
                                                        <p>Chọn đánh giá của bạn:</p>
                                                        <div class="rating1">
                                                            <input type="radio" checked name="rating" value="5" id="5">
                                                            <label title="Tuyệt vời quá" for="5">☆</label>
                                                            <input type="radio" name="rating" value="4" id="4">
                                                            <label title="Rất tốt" for="4">☆</label>
                                                            <input type="radio" name="rating" value="3" id="3">
                                                            <label title="Bình thường" for="3">☆</label>
                                                            <input type="radio" name="rating" value="2" id="2">
                                                            <label title="Tạm được" for="2">☆</label>
                                                            <input type="radio" name="rating" value="1" id="1">
                                                            <label title="Không thích" for="1">☆</label>
                                                        </div>
                                                    </div>
                                                    <p><label for="review">Nhập đánh giá của bạn:</label> <textarea style="border-radius: 5px;" name="review" class="@error('review') is-invalid @enderror" cols="30" rows="10" placeholder="nhập đánh giá về sản phẩm (tối thiểu 60 ký tự)">{{old('review')}}</textarea></p>
                                                    @error('review')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <p><input style="margin-left: 45%; border-radius: 5px; " type="submit" value="Gửi"></p>
                                                </form>
                                            </div>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="details">
                                            <div style="padding-left: 8%;">
                                                {!! $product->specifications_all !!}
                                            </div>
                                        </div>

                                        <!-- <div role="tabpanel" class="tab-pane fade" id="comment">

                                        </div> -->
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