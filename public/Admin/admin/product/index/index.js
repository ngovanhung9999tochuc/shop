(function() {
    var base_url = window.location.origin;
    const modal = document.getElementById('id01');
    const formPrice = document.getElementById('form-price');
    const btnPrices = document.querySelectorAll('.btn-price');
    let idProduct = '';
    //event
    // When the user clicks anywhere outside of the modal, close it

    window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        //event 
    btnPrices.forEach(function(btn) {
        btn.addEventListener('click', function() {
            let [x, id] = this.id.split('_');
            idProduct = id;
            modal.style.display = "block";
            const tdUnitPrice = document.getElementById('td-unit-price-' + idProduct);
            const tdPromotionPrice = document.getElementById('td-promotion-price-' + idProduct);
            formPrice['unit_price'].value = tdUnitPrice.innerHTML.split('.')[0].replace(/[^0-9]/gi, '');
            formPrice['promotion_price'].value = tdPromotionPrice.innerHTML.replace(/[^0-9]/gi, '');
        });
    });

    formPrice.addEventListener('submit', addProductPrice)


    //function
    function addProductPrice(event) {
        event.preventDefault();
        let _token = this['_token'].value;
        let unitPrice = this['unit_price'].value;
        let promotionPrice = this['promotion_price'].value;
        const tdUnitPrice = document.getElementById('td-unit-price-' + idProduct);
        const tdPromotionPrice = document.getElementById('td-promotion-price-' + idProduct);
        request(base_url + '/admin/product/price/' + idProduct, JSON.stringify({
            '_token': _token,
            'unit_price': unitPrice,
            'promotion_price': promotionPrice
        }), function(data) {
            let result = JSON.parse(data);
            if (result['result']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn thêm giá sản phẩm thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                tdUnitPrice.innerHTML = Number(unitPrice).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
                tdPromotionPrice.innerHTML = promotionPrice + '%';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn thêm giá sản phẩm không thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    }





    function request(url = "", para = "", callbackSuccess = function() {}, callbackError = function(err) { console.log(err) }) {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                callbackSuccess(this.responseText);
            } else if (this.readyState == 4) {
                callbackError(this);
            }
        }
        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/json");
        xmlHttp.send(para);
    }

})()