//variables
let arrClass = [{
    'class': 'btn-primary',
    'textStatus': 'Mới'
}, {
    'class': 'btn-info',
    'textStatus': 'Xác nhận'
}, {
    'class': 'btn-warning',
    'textStatus': 'Đang chuyển'
}, {
    'class': 'btn-success',
    'textStatus': 'Thành công'
}, {
    'class': 'btn-danger',
    'textStatus': ' Thất bại'
}];
const base_url = window.location.origin;
const btnStatus = document.querySelectorAll('.btn-dropdown-status');
const _token = document.getElementById('_token');
let modal = document.getElementById('id01');
let modal2 = document.getElementById('id02');
let btnShowInfo = document.querySelectorAll('.btn-show-info');
//event
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2) {
        modal.style.display = "none";
        modal2.style.display = "none";
    }
}

//show info

function showInfo(info) {
    let [x, id] = info.id.split('-');
    let fullName = document.getElementById('full-name');
    let content = document.getElementById('content');
    let tableProduct = document.getElementById('table-product');
    let imageAvata = document.getElementById('image-avata');

    request(base_url + '/admin/bill/show', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
            let bill = data['bill'];
            let user = bill['user'];
            let products = data['dataProduct'];

            //su ly user
            imageAvata.src = user['image_icon'];
            fullName.innerHTML = user['name'];
            //su ly thong tin
            let textContent = '';
            textContent += '<div class="card-body">';
            textContent += '<div class="row">';
            textContent += '<div class="col-sm-3">';
            textContent += '<h6 class="mb-0">Email</h6>';
            textContent += '</div>';
            textContent += '<div class="col-sm-9 text-secondary">';
            textContent += bill['email'];
            textContent += '</div>';
            textContent += '</div>';
            textContent += '<hr>';
            textContent += '<div class="row">';
            textContent += '<div class="col-sm-3">';
            textContent += '<h6 class="mb-0">Địa Chỉ</h6>';
            textContent += '</div>';
            textContent += '<div class="col-sm-9 text-secondary">';
            textContent += bill['address'];
            textContent += '</div>';
            textContent += '</div>';
            textContent += '<hr>';
            textContent += '<div class="row">';
            textContent += '<div class="col-sm-3">';
            textContent += '<h6 class="mb-0">Số Điện Thoại</h6>';
            textContent += '</div>';
            textContent += '<div class="col-sm-9 text-secondary">';
            textContent += bill['phone'];
            textContent += '</div>';
            textContent += '</div>';
            textContent += '<hr>';
            textContent += '<div class="row">';
            textContent += '<div class="col-sm-3">';
            textContent += '<h6 class="mb-0">Ngày Đặt Hàng</h6>';
            textContent += '</div>';
            textContent += '<div class="col-sm-9 text-secondary">';
            textContent += bill['date_order'];
            textContent += '</div>';
            textContent += '</div>';
            textContent += '<hr>';
            textContent += '<div class="row">';
            textContent += '<div class="col-sm-3">';
            textContent += '<h6 class="mb-0">Tổng Số Lượng</h6>';
            textContent += '</div>';
            textContent += '<div class="col-sm-9 text-secondary">';
            textContent += bill['quantity'];
            textContent += '</div>';
            textContent += '</div>';
            textContent += '<hr>';
            textContent += '<div class="row">';
            textContent += '<div class="col-sm-3">';
            textContent += '<h6 class="mb-0">Tổng Tiền</h6>';
            textContent += '</div>';
            textContent += '<div class="col-sm-9 text-secondary">';
            textContent += Number(bill['total']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
            textContent += '</div>';
            textContent += '</div>';
            textContent += '</div>';
            content.innerHTML = textContent;

            let tr = '';

            for (const product in products) {
                let color = '';
                if (products[product]['quantityInventory'] - products[product]['quantityRequired'] <= 0) {
                    color = 'background-color: rgb(250, 74, 74);';
                }
                let td = '';
                td += '<tr>';
                td += '<td>' + products[product]['id'] + '</td>';
                td += '<td>' + products[product]['name'] + '</td>';
                td += '<td>' + products[product]['quantityRequired'] + '</td>';
                td += '<td>' + Number(products[product]['unit_price']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ' + '</td>';
                //td += '<td><img src="' + products[product]['image'] + '" style="width:80px ; height: 80px;" /></td>';
                td += '<td style="' + color + '">' + products[product]['quantityInventory'] + '</td>';
                td += '</tr>';
                tr += td;
            }
            tableProduct.innerHTML = tr;
            modal.style.display = "block";
        }
    });
}


//change status

//

function changeStatus(s) {
    let [x, btnId, status] = s.id.split('-');
    let [y, id] = btnId.split('_');
    let tableProductInventory = document.getElementById('table-product-inventory');
    request(base_url + '/admin/bill/status', JSON.stringify({
        '_token': _token.value,
        'status': status,
        'id': id
    }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
            let status = data['status'];
            const btnText = document.getElementById('btn-text-' + id);
            const btnDropdown = document.getElementById('btn-dropdown-' + id);
            for (const i of arrClass) {
                btnText.classList.remove(i['class']);
                btnDropdown.classList.remove(i['class']);
            }
            btnText.innerHTML = arrClass[status]['textStatus'];
            btnText.classList.add(arrClass[status]['class']);
            btnDropdown.classList.add(arrClass[status]['class']);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Kho không đủ sản phẩm để giao hàng',
                showConfirmButton: false,
                timer: 4000
            });
            let tr = '';
            let products = data['inventorys']
            for (const product in products) {

                let td = '';
                td += '<tr>';
                td += '<td>' + products[product]['id'] + '</td>';
                td += '<td>' + products[product]['name'] + '</td>';
                td += '<td>' + products[product]['quantityInventory'] + '</td>';
                td += '<td>' + products[product]['quantityRequired'] + '</td>';
                //td += '<td><img src="' + products[product]['image'] + '" style="width:80px ; height: 80px;" /></td>';
                td += '</tr>';
                tr += td;
            }
            tableProductInventory.innerHTML = tr;
            modal2.style.display = "block";
        }
    });
}





//function
function request(url = "", para = "", callbackSuccess = function() {}, callbackError = function(err) { console.log(err) }) {
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

/* btnShowInfo.forEach(function(btn) {
    btn.addEventListener('click', function() {
        let [x, id] = this.id.split('-');
        let fullName = document.getElementById('full-name');
        let content = document.getElementById('content');
        let tableProduct = document.getElementById('table-product');
        let imageAvata = document.getElementById('image-avata');

        request(base_url + '/admin/bill/show', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                let bill = data['bill'];
                let user = bill['user'];
                let products = bill['products'];

                //su ly user
                imageAvata.src = user['image_icon'];
                fullName.innerHTML = user['name'];
                //su ly thong tin
                let textContent = '';
                textContent += '<div class="card-body">';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Email</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['email'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Địa Chỉ</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['address'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Số Điện Thoại</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['phone'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Ngày Đặt Hàng</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['date_order'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Tổng Số Lượng</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['quantity'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Tổng Tiền</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += Number(bill['total']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                textContent += '</div>';
                textContent += '</div>';
                textContent += '</div>';
                content.innerHTML = textContent;

                let tr = '';
                for (const product of products) {

                    let td = '';
                    td += '<tr>';
                    td += '<td>' + product['id'] + '</td>';
                    td += '<td>' + product['name'] + '</td>';
                    td += '<td>' + product['pivot']['quantity'] + '</td>';
                    td += '<td>' + Number(product['pivot']['unit_price']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + '</td>';
                    td += '<td><img src="' + product['image'] + '" style="width:80px ; height: 80px;" /></td>';
                    td += '</tr>';
                    tr += td;
                }
                tableProduct.innerHTML = tr;
                modal.style.display = "block";
            }
        });
    });
});

 */

/*     btnStatus.forEach(function(btn) {
       btn.addEventListener('click', function() {
           let [x, btnId, status] = this.id.split('-');
           let [y, id] = btnId.split('_');
           let tableProductInventory = document.getElementById('table-product-inventory');
           request(base_url + '/admin/bill/status', JSON.stringify({
               '_token': _token.value,
               'status': status,
               'id': id
           }), function(data) {
               data = JSON.parse(data);
               if (data['success']) {
                   let status = data['status'];
                   const btnText = document.getElementById('btn-text-' + id);
                   const btnDropdown = document.getElementById('btn-dropdown-' + id);
                   for (const i of arrClass) {
                       btnText.classList.remove(i['class']);
                       btnDropdown.classList.remove(i['class']);
                   }
                   btnText.innerHTML = arrClass[status]['textStatus'];
                   btnText.classList.add(arrClass[status]['class']);
                   btnDropdown.classList.add(arrClass[status]['class']);
               } else {
                   Swal.fire({
                       icon: 'warning',
                       title: 'Kho không đủ sản phẩm để giao hàng',
                       showConfirmButton: false,
                       timer: 4000
                   });
                   let tr = '';
                   let products = data['inventorys']
                   for (const product in products) {

                       let td = '';
                       td += '<tr>';
                       td += '<td>' + products[product]['id'] + '</td>';
                       td += '<td>' + products[product]['name'] + '</td>';
                       td += '<td>' + products[product]['quantityInventory'] + '</td>';
                       td += '<td>' + products[product]['quantityRequired'] + '</td>';
                       td += '<td><img src="' + products[product]['image'] + '" style="width:80px ; height: 80px;" /></td>';
                       td += '</tr>';
                       tr += td;
                   }
                   tableProductInventory.innerHTML = tr;
                   modal2.style.display = "block";
               }
           });
       });
   });
*/