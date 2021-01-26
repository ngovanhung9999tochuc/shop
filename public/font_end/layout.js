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
        url: 'http://localhost/shop/public/login',
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
        url: base_url + '/register',
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





/* btnAddCarts.forEach(function(btnAdd) {
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
 */
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
            //alert(window.location.href);
            //alert(base_url + '/order');
            if (window.location.href == base_url + '/order') {
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

            if (window.location.href == base_url + '/order') {
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