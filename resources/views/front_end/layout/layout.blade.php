<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thế giới điện tử</title>

  <!-- Google Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="/ustora/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/ustora/css/font-awesome.min.css">
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/ustora/css/owl.carousel.css">
  <link rel="stylesheet" href="/ustora/style.css">
  <link rel="stylesheet" href="/ustora/css/responsive.css">
  <link rel="stylesheet" href="/ustora/style1.css">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
  <script src="/ustora/jquery.min.js"></script>
  <!-- Bootstrap JS form CDN -->
  <script src="/ustora/bootstrap.min.js"></script>
  <!-- jQuery sticky menu -->
  <script src="/ustora/js/owl.carousel.min.js"></script>
  <script src="/ustora/js/jquery.sticky.js"></script>

  <!-- jQuery easing -->
  <script src="/ustora/js/jquery.easing.1.3.min.js"></script>

  <!-- Main Script -->
  <script src="/ustora/js/main.js"></script>

  <!-- Slider -->
  <script type="text/javascript" src="/ustora/js/bxslider.min.js"></script>
  <script type="text/javascript" src="/ustora/js/script.slider.js"></script>
  <script>
    //shopping cart show form
    const base_url = window.location.origin;
    let btnShoppingCart = document.getElementById('btn-shopping-cart');
    let w3lssbmincart = document.getElementById('w3lssbmincart');
    let btnSbmincartCloser = document.getElementById('btn-sbmincart-closer');


    btnShoppingCart.addEventListener('click', function() {
      w3lssbmincart.style.display = 'block';
    });

    btnSbmincartCloser.addEventListener('click', function() {
      w3lssbmincart.style.display = 'none';
    });
    //cart
    const btnAddCarts = document.querySelectorAll('.add-product-to-cart');
    const _token = document.getElementById('_token');
    const totalPrice1 = document.getElementById('total-price-1');
    const totalPrice2 = document.getElementById('total-price-2');
    const totalQuantity = document.getElementById('total-quantity');
    const ulListItem = document.getElementById('ul-list-item');

    //them item cart
    btnAddCarts.forEach(function(btnAdd) {
      btnAdd.addEventListener('click', function() {
        let [x, y, id] = this.id.split('-');
        requestCart(base_url + '/cart/add', JSON.stringify({
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
              dataLi += '<div class="sbmincart-details-name"> <a class="sbmincart-name" href="' + base_url + '/detail/' + product['id'] + '">' + product['name'] + '</a></div>';
              dataLi += '<div class="sbmincart-details-quantity"> <input id="input-quantity-' + product['id'] + '" onchange="changeQuantity(this)" class="sbmincart-quantity" name="quantity" type="number" min="1" value="' + data['item']['quantity'] + '" autocomplete="off"> </div>';
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
      });
    });

    //function
    function changeQuantity(inputQuantity) {
      let [x, y, id] = inputQuantity.id.split('-');
      requestCart(base_url + '/cart/change', JSON.stringify({
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
      requestCart(base_url + '/cart/delete', JSON.stringify({
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

</body>

</html>