<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="wrapper row">
                <div class=" col-md-9 navigationDesktop">
                    <nav>
                        {!!$htmlMenu!!}
                    </nav>
                </div>
                <div class="col-md-3">
                    <div id="btn-shopping-cart" class="shopping-item">
                        <a>Giỏ hàng - <span id="total-price-1" class="cart-amunt">{{number_format($dataCart['totalPrice'])}}đ</span> <i class="fa fa-shopping-cart"></i></a>
                    </div>
                </div>
                <div id="w3lssbmincart">
                    <form method="post" class="" action="" target=""> <button id="btn-sbmincart-closer" type="button" class="sbmincart-closer">x</button>
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <ul id="ul-list-item">
                            @foreach($dataCart['items'] as $item)
                            <li id="item-{{$item['product']->id}}" class="sbmincart-item">
                                <div class="sbmincart-details-name"> <a class="sbmincart-name" href="{{route('detail',$item['product']->id)}}">{{$item['product']->name}}</a></div>
                                <div class="sbmincart-details-quantity"> <input id="input-quantity-{{$item['product']->id}}" onchange="changeQuantity(this)" class="sbmincart-quantity" name="quantity" type="number" min="1" value="{{$item['quantity']}}" autocomplete="off"> </div>
                                <div class="sbmincart-details-remove"> <button id="btn-close-{{$item['product']->id}}" onclick="deleteItem(this)" type="button" class="sbmincart-remove" data-sbmincart-idx="0">×</button> </div>
                                <div class="sbmincart-details-price"> <span id="total-product-{{$item['product']->id}}" class="sbmincart-price">{{number_format($item['quantity'] * ($item['product']->unit_price - $item['product']->unit_price * $item['product']->promotion_price / 100))}}đ</span> </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="sbmincart-footer">
                            <div class="sbmincart-subtotal">Tổng tiền:<span style="color: #5a88ca;" id="total-price-2">{{number_format($dataCart['totalPrice'])}}đ</span> &nbsp; &nbsp; &nbsp;số lượng:<span id="total-quantity" style="color: #5a88ca;">{{$dataCart['totalQty']}}</span></div> <a><button class="sbmincart-submit" type="button">Đặt hàng</button></a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div> <!-- End mainmenu area -->