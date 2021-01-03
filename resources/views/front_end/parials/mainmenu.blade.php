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
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                       <a href="{{route('home')}}"><img style="width: 176px; height: 57px;" src="/logo/logo.png"></a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="btn-shopping-cart" class="shopping-item">
                        <a >Giỏ hàng - <span class="cart-amunt">1,000,000,000đ</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">5</span></a>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                <div class="navigationDesktop" style="background-color: #f0f1f5;">
                    <nav>
                        {!!$htmlMenu!!}
                    </nav>
                </div>
            </div>

        </div>
    </div>
</div> <!-- End mainmenu area -->