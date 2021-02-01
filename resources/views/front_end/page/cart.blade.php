@extends('front_end.layout.layout')
@section('content')
@section('css')
<link rel="stylesheet" title="style" href="ustora/assets/dest/css/style.css">


@endsection
<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Đơn hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<div class="container">
    <div id="content">

        <form action="{{route('order.enter')}}" method="post" class="beta-form-checkout">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Họ tên*</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{auth()->user()->name}}" readonly placeholder="nhập họ tên">
                        @error('name')
                        <br />
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email*</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{auth()->user()->email}}" placeholder="nhập email">
                        @error('email')
                        <br />
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ*</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{auth()->user()->address}}" placeholder="nhập địa chỉ">
                        @error('address')
                        <br />
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Điện thoại*</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{auth()->user()->phone}}" placeholder="nhập điện thoại">
                        @error('phone')
                        <br />
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="your-order">
                        <div class="your-order-head">
                            <h5>Đơn hàng của bạn</h5>
                        </div>
                        <div class="your-order-body" style="padding: 0px 10px">
                            <div class="your-order-item">
                                <div id="list-item">
                                    <!--  one item	 -->
                                    @if(Session::has('cart'))
                                    @foreach($items as $item)
                                    <div id="media-{{$item['product']->id}}" class="media">
                                        <img width="20%" src="{{asset($item['product']->image)}}" alt="" class="pull-left">
                                        <div class="media-body">
                                            <p class="font-large">{{$item['product']->name}}</p>
                                            <span class="color-gray your-order-info">Giá: <span id="price-{{$item['product']->id}}">{{number_format($item['quantity'] * ($item['product']->unit_price - $item['product']->unit_price * $item['product']->promotion_price / 100))}}</span>đ</span>
                                            <span class="color-gray your-order-info">Số Lượng: <span id="quantity-{{$item['product']->id}}">{{$item['quantity']}}</span></span>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    <!-- end one item -->
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="your-order-item">
                                <div class="pull-left">
                                    <p class="your-order-f18">Tổng số lượng:</p>
                                </div>
                                <div class="pull-right">
                                    <h5 id="order-total-quantity" class="color-black">{{number_format($totalQty)}}</h5>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="your-order-item">
                                <div class="pull-left">
                                    <p class="your-order-f18">Tổng tiền:</p>
                                </div>
                                <div class="pull-right">
                                    <h5 id="order-total-price" class="color-black">{{number_format($totalPrice)}}đ</h5>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="your-order-head" style="height: 32px; line-height: 32px; font-size: 16px;">
                            <b>Hình thức thanh toán</b>
                        </div>

                        <div class="row your-order-body">
                            <ul class="col-md-6 payment_methods methods">
                                <li class="payment_method_bacs">
                                    <input type="radio" class="input-radio" name="payment_method" value="COD" checked="checked">
                                    <label title="Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho nhân viên giao hàng" for="payment_method_bacs">Thanh toán khi nhận hàng</label>
                                </li>
                            </ul>
                            <div class="col-md-6 text-center"><button style="color: #5a88ca; border-radius: 3px;" class="beta-btn" type="submit">Đặt hàng</button></div>
                        </div>
                    </div> <!-- .your-order -->
                </div>
            </div>
        </form>
    </div> <!-- #content -->
</div> <!-- .container -->

@endsection

@section('js')

@endsection