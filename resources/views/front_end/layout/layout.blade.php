<!DOCTYPE html>
<html lang="en">

<head>
  <base href="{{asset('')}}">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thế giới điện tử</title>

  <!-- Google Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('/ustora/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/ustora/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('/ustora/css/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('/ustora/style.css') }}">
  <link rel="stylesheet" href="{{ asset('/ustora/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('/ustora/style1.css')}}">
  <link rel="stylesheet" href="{{ asset('/ustora/login.css')}}">
  <link rel="stylesheet" href="{{ asset('/ustora/login1.css')}}">

  @yield('css')

</head>

<body>



  <!-- header area -->
  @include('front_end.parials.header')
  <!-- site branding area -->

  <!-- mainmenu area -->
  @include('front_end.parials.mainmenu')

  <!-- content -->
  @yield('content')

  <!-- footer top area -->
  @include('front_end.parials.footer')
  <!-- footer bottom area -->


  <!-- JQuery-->
  <!-- Latest jQuery form server -->
  <script src="{{ asset('/ustora/jquery.min.js')}}"></script>
  <!-- Bootstrap JS form CDN -->
  <script src="{{ asset('/ustora/bootstrap.min.js')}}"></script>
  <!-- jQuery sticky menu -->
  <script src="{{ asset('/ustora/js/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('/ustora/js/jquery.sticky.js')}}"></script>

  <!-- jQuery easing -->
  <script src="{{ asset('/ustora/js/jquery.easing.1.3.min.js')}}"></script>

  <!-- Main Script -->
  <script src="{{ asset('/ustora/js/main.js')}}"></script>

  <!-- Slider -->
  <script type="text/javascript" src="{{ asset('/ustora/js/bxslider.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('/ustora/js/script.slider.js')}}"></script>
  <script src="{{asset('vendor/sweetalert2@10.js')}}"></script>
  <!-- <script src="{{asset('font_end/layout.js')}}"></script> -->
  <script>
    //shopping cart show form
    let base_url = "{{ asset('') }}";
    base_url = [...base_url];
    base_url.pop();
    base_url = base_url.join("");
    let btnShoppingCart = document.getElementById('btn-shopping-cart');
    let w3lssbmincart = document.getElementById('w3lssbmincart');
    let btnSbmincartCloser = document.getElementById('btn-sbmincart-closer');


    btnShoppingCart.addEventListener('click', function() {
      w3lssbmincart.style.display = 'block';
    });

    btnSbmincartCloser.addEventListener('click', function() {
      w3lssbmincart.style.display = 'none';
    });
    //LOGIN
    const modal = document.getElementById('id01');
    const modal2 = document.getElementById('id02');
    const btnLogin = document.getElementById('btn-login');
    const btnRegister = document.getElementById('btn-register');
    //event
    window.onclick = function(event) {
      if (event.target == modal || event.target == modal2) {
        modal.style.display = "none";
        modal2.style.display = "none";
      }
    }

    btnLogin.addEventListener('click', function() {
      clearErrorMessagesFormLogin();
      document.getElementById('form-login').reset();
      modal.style.display = "block";
    });

    btnRegister.addEventListener('click', function() {
      clearErrorMessagesFormRegister();
      document.getElementById('form-register').reset();
      modal2.style.display = "block";
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#form-login').submit(function(e) {
      e.preventDefault();
      clearErrorMessagesFormLogin();
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: '{{route("login")}}',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
          this.reset();
          if (data['success']) {
            //checkAdmin
            document.getElementById('display-login-logout').style.display = 'none';
            document.getElementById('header-right-login').style.display = 'block';
            //name-user-login
            if (data['checkAdmin']) {
              document.getElementById('display-admin').style.display = 'block';
            }
            document.getElementById('name-user-login').innerHTML = data['user']['name'];

            Swal.fire({
              icon: 'success',
              title: 'Bạn đăng nhập thành công',
              showConfirmButton: false,
              timer: 4000
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Tài khoản hoặc mật khẩu không đúng',
              showConfirmButton: false,
              timer: 4000
            });
          }

        },
        error: function(error) {
          let errors = error.responseJSON['errors'];
          for (const key in errors) {
            $('#validation-login-' + key).html(errors[key][0]);
          }
        }
      });
    });

    $('#form-register').submit(function(e) {
      e.preventDefault();
      clearErrorMessagesFormRegister();
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: '{{route("register")}}',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
          this.reset();
          console.log(data);
          if (data['success']) {

            document.getElementById('display-login-logout').style.display = 'none';
            document.getElementById('header-right-login').style.display = 'block';
            //name-user-login
            document.getElementById('name-user-login').innerHTML = data['user']['name'];
            Swal.fire({
              icon: 'success',
              title: 'Bạn đăng ký thành công',
              showConfirmButton: false,
              timer: 4000
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'bạn đăng ký thành công, đăng nhập không thành công',
              showConfirmButton: false,
              timer: 4000
            });
          }

        },
        error: function(error) {
          let errors = error.responseJSON['errors'];
          for (const key in errors) {
            $('#validation-register-' + key).html(errors[key][0]);
          }
        }
      });
    });

    //CART
    const btnAddCarts = document.querySelectorAll('.add-product-to-cart');
    const _token = document.getElementById('_token');
    const totalPrice1 = document.getElementById('total-price-1');
    const totalPrice2 = document.getElementById('total-price-2');
    const totalQuantity = document.getElementById('total-quantity');
    const ulListItem = document.getElementById('ul-list-item');


    //them item cart
    function addItemCart(add) {
      let [x, y, id] = add.id.split('-');
      requestCart('{{route("cart.add")}}', JSON.stringify({
        '_token': _token.value,
        'id': id
      }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
          let product = data['item']['product'];
          let itemExists = document.getElementById("item-" + product['id']);
          let price = data['item']['quantity'] * (product['unit_price'] - product['unit_price'] * product['promotion_price'] / 100);


          totalPrice1.innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          totalPrice2.innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          totalQuantity.innerHTML = data['totalQty'];

          if (itemExists !== null) {
            document.getElementById("input-quantity-" + product['id']).value = data['item']['quantity'];
            document.getElementById("total-product-" + product['id']).innerHTML = Number(price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          } else {
            let li = document.createElement('li');
            let dataLi = '';
            li.setAttribute("id", "item-" + product['id']);
            li.classList.add("sbmincart-item");
            dataLi += '<div class="sbmincart-details-name"> <a class="sbmincart-name" href="{{route("detail",' + product["id"] + ')}}">' + product['name'] + '</a></div>';
            dataLi += '<div class="sbmincart-details-quantity"> <input id="input-quantity-' + product['id'] + '" onchange="changeQuantity(this)" class="" name="quantity" type="number" min="1" max="10" value="' + data['item']['quantity'] + '" autocomplete="off"> </div>';
            dataLi += '<div class="sbmincart-details-remove"> <button id="btn-close-' + product['id'] + '" onclick="deleteItem(this)" type="button" class="sbmincart-remove" data-sbmincart-idx="0">×</button> </div>';
            dataLi += '<div class="sbmincart-details-price"> <span id="total-product-' + product['id'] + '" class="sbmincart-price">' + Number(price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ'; + '</span> </div>';
            li.innerHTML = dataLi;
            ulListItem.appendChild(li);
          }
          w3lssbmincart.style.display = 'block';
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi hệ thống !',
            showConfirmButton: false,
            timer: 4000
          });
        }
      });
    }





    //function
    function clearErrorMessagesFormLogin() {
      document.getElementById('validation-login-email').innerHTML = '';
      document.getElementById('validation-login-password').innerHTML = '';
    }

    function clearErrorMessagesFormRegister() {
      document.getElementById('validation-register-fullname').innerHTML = '';
      document.getElementById('validation-register-username').innerHTML = '';
      document.getElementById('validation-register-password').innerHTML = '';
      document.getElementById('validation-register-repassword').innerHTML = '';
    }


    function changeQuantity(inputQuantity) {
      let [x, y, id] = inputQuantity.id.split('-');
      requestCart('{{route("cart.change")}}', JSON.stringify({
        '_token': _token.value,
        'id': id,
        'quantity': inputQuantity.value
      }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
          let product = data['item']['product'];
          let price = data['item']['quantity'] * (product['unit_price'] - product['unit_price'] * product['promotion_price'] / 100);
          totalPrice1.innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          totalPrice2.innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          totalQuantity.innerHTML = data['totalQty'];
          document.getElementById("total-product-" + product['id']).innerHTML = Number(price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';

          if (window.location.href == '{{route("order")}}') {
            document.getElementById('order-total-price').innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
            document.getElementById('order-total-quantity').innerHTML = data['totalQty'];
            document.getElementById("price-" + product['id']).innerHTML = Number(price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            document.getElementById("quantity-" + product['id']).innerHTML = data['item']['quantity'];
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi hệ thống !',
            showConfirmButton: false,
            timer: 4000
          });
        }
      });
    }

    function deleteItem(btnDelete) {
      let [x, y, id] = btnDelete.id.split('-');
      requestCart('{{route("cart.delete")}}', JSON.stringify({
        '_token': _token.value,
        'id': id
      }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
          totalPrice1.innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          totalPrice2.innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
          totalQuantity.innerHTML = data['totalQty'];
          let li = document.getElementById('item-' + data['id']);
          ulListItem.removeChild(li);

          if (window.location.href == '{{route("order")}}') {
            document.getElementById('order-total-price').innerHTML = Number(data['totalPrice']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
            document.getElementById('order-total-quantity').innerHTML = data['totalQty'];
            let listItem = document.getElementById('list-item');
            let child = document.getElementById('media-' + data['id']);
            listItem.removeChild(child);
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Lỗi hệ thống !',
            showConfirmButton: false,
            timer: 4000
          });
        }
      });
    }

    function requestCart(url = "", para = "", callbackSuccess = function() {}, callbackError = function(err) {
      console.log(err)
    }) {
      let xmlHttp = new XMLHttpRequest();
      xmlHttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          callbackSuccess(this.responseText);
        } else if (this.readyState == 4 && this.status == 500) {
          callbackError(this.responseText);
        }
      }
      xmlHttp.open("POST", url, true);
      xmlHttp.setRequestHeader("Content-type", "application/json");
      xmlHttp.send(para);
    }
  </script>
  @yield('js')
  @php
  if(Session::has('messageCheckOut')){
  echo Session::get('messageCheckOut');
  }
  @endphp

  <style>
    .fb-livechat,
    .fb-widget {
      display: none
    }

    .ctrlq.fb-button,
    .ctrlq.fb-close {
      position: fixed;
      right: 10px;
      cursor: pointer;
      padding: 0 8px;
      background: #ff3200;
    }

    .ctrlq.fb-button {
      z-index: 999;
      background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEyOCAxMjgiIGhlaWdodD0iMTI4cHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB3aWR0aD0iMTI4cHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnPjxyZWN0IGZpbGw9IiMwMDg0RkYiIGhlaWdodD0iMTI4IiB3aWR0aD0iMTI4Ii8+PC9nPjxwYXRoIGQ9Ik02NCwxNy41MzFjLTI1LjQwNSwwLTQ2LDE5LjI1OS00Niw0My4wMTVjMCwxMy41MTUsNi42NjUsMjUuNTc0LDE3LjA4OSwzMy40NnYxNi40NjIgIGwxNS42OTgtOC43MDdjNC4xODYsMS4xNzEsOC42MjEsMS44LDEzLjIxMywxLjhjMjUuNDA1LDAsNDYtMTkuMjU4LDQ2LTQzLjAxNUMxMTAsMzYuNzksODkuNDA1LDE3LjUzMSw2NCwxNy41MzF6IE02OC44NDUsNzUuMjE0ICBMNTYuOTQ3LDYyLjg1NUwzNC4wMzUsNzUuNTI0bDI1LjEyLTI2LjY1N2wxMS44OTgsMTIuMzU5bDIyLjkxLTEyLjY3TDY4Ljg0NSw3NS4yMTR6IiBmaWxsPSIjRkZGRkZGIiBpZD0iQnViYmxlX1NoYXBlIi8+PC9zdmc+) center no-repeat #0084ff;
      width: 40px;
      height: 40px;
      text-align: center;
      bottom: 30px;
      border: 0;
      outline: 0;
      border-radius: 60px;
      -webkit-border-radius: 60px;
      -moz-border-radius: 60px;
      -ms-border-radius: 60px;
      -o-border-radius: 60px;
      box-shadow: 0 1px 6px rgba(0, 0, 0, .06), 0 2px 32px rgba(0, 0, 0, .16);
      -webkit-transition: box-shadow .2s ease;
      background-size: 80%;
      transition: all .2s ease-in-out
    }

    .ctrlq.fb-button:focus,
    .ctrlq.fb-button:hover {
      transform: scale(1.1);
      box-shadow: 0 2px 8px rgba(0, 0, 0, .09), 0 4px 40px rgba(0, 0, 0, .24)
    }

    .fb-widget {
      background: #fff;
      z-index: 1000;
      position: fixed;
      width: 360px;
      height: 435px;
      overflow: hidden;
      opacity: 0;
      bottom: 0;
      right: 24px;
      border-radius: 6px;
      -o-border-radius: 6px;
      -webkit-border-radius: 6px;
      box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
      -webkit-box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
      -moz-box-shadow: 0 5px 40px rgba(0, 0, 0, .16);
      -o-box-shadow: 0 5px 40px rgba(0, 0, 0, .16)
    }

    .fb-credit {
      text-align: center;
      margin-top: 8px
    }

    .fb-credit a {
      transition: none;
      color: #eee;
      font-family: Helvetica, Arial, sans-serif;
      font-size: 12px;
      text-decoration: none;
      border: 0;
      font-weight: 400
    }

    .ctrlq.fb-overlay {
      z-index: 0;
      position: fixed;
      height: 100vh;
      width: 100vw;
      -webkit-transition: opacity .4s, visibility .4s;
      transition: opacity .4s, visibility .4s;
      top: 0;
      left: 0;
      background: rgba(0, 0, 0, .05);
      display: none
    }

    .ctrlq.fb-close {
      z-index: 4;
      padding: 0 8px;
      background: #ff3200;
      font-weight: 700;
      font-size: 11px;
      color: #fff;
      margin: 0 8px 8px 0;
      border-radius: 3px
    }

    .ctrlq.fb-close::after {
      content: "X";
      font-family: sans-serif
    }

    .bubble {
      width: 20px;
      height: 20px;
      background: #c00;
      color: #fff;
      position: absolute;
      z-index: 999999999;
      text-align: center;
      vertical-align: middle;
      top: -2px;
      left: -5px;
      border-radius: 50%;
    }

    .bubble-msg {
      width: 120px;
      left: -140px;
      top: 5px;
      position: relative;
      background: rgba(59, 89, 152, .8);
      color: #fff;
      padding: 5px 8px;
      border-radius: 5px;
      text-align: center;
      font-size: 13px;
    }
  </style>
  <div class="fb-livechat">
    <div class="ctrlq fb-overlay"></div>
    <div class="fb-widget">
      <div class="ctrlq fb-close"></div>
      <div class="fb-page" data-href="https://www.facebook.com/thegioidientu1010/" data-tabs="messages" data-width="360" data-height="400" data-small-header="true" data-hide-cover="true" data-show-facepile="false"> </div>
      <div class="fb-credit"> <a href="https://hoaky68.com" target="_blank" rel="noopener noreferrer">Powered by Hoaky68</a> </div>
      <div id="fb-root"></div>
    </div><a href="https://m.me/&#039; + link_mobile + &#039;" title="Gửi tin nhắn cho chúng tôi qua Facebook" class="ctrlq fb-button" rel="nofollow" target="_blank">
      <div class="bubble">1</div>
      <div class="bubble-msg">Bạn cần hỗ trợ?</div>
    </a>
  </div>
  <script src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&#038;version=v2.9"></script>
  <script>
    jQuery(document).ready(function($) {
      function detectmob() {
        if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
          return true;
        } else {
          return false;
        }
      }
      var t = {
        delay: 125,
        overlay: $(".fb-overlay"),
        widget: $(".fb-widget"),
        button: $(".fb-button")
      };
      setTimeout(function() {
        $("div.fb-livechat").fadeIn()
      }, 8 * t.delay);
      if (!detectmob()) {
        $(".ctrlq").on("click", function(e) {
          e.preventDefault(), t.overlay.is(":visible") ? (t.overlay.fadeOut(t.delay), t.widget.stop().animate({
            bottom: 0,
            opacity: 0
          }, 2 * t.delay, function() {
            $(this).hide("slow"), t.button.show()
          })) : t.button.fadeOut("medium", function() {
            t.widget.stop().show().animate({
              bottom: "30px",
              opacity: 1
            }, 2 * t.delay), t.overlay.fadeIn(t.delay)
          })
        })
      }
    });
  </script>
</body>

</html>