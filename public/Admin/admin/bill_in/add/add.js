(function() {
    const btnSearchProducts = document.getElementById('search-products');
    const _token = document.getElementById('_token').value;
    const productListAreLookingFor = document.getElementById('product-list-are-looking-for');
    const ulProductList = document.getElementById('ul-product-list');
    const proSearchAppend = document.getElementById('pro_search_append');
    const totalQuantity = document.getElementById('total-quantity');
    const totalPrice = document.getElementById('total-price');
    const inputProductBill = document.getElementById('data-product-bill');
    const dataProductBill = {};
    //Request voi callback voi 1 tham so--thuc hien truy van

    function queryProduct(url = "", para = "", callback = function() {}) {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                callback(this.responseText);
            }
        }
        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/json");
        xmlHttp.send(para);
    }


    //event
    btnSearchProducts.addEventListener('keyup', function() {
        queryProduct("http://localhost:8000/admin/billin/products", JSON.stringify({
                '_token': _token,
                'table_search': btnSearchProducts.value
            }),
            function(data) {
                let products = JSON.parse(data);
                let li = '';
                for (const p of products) {
                    li += '<li  data-product-type="' + p.id + '_' + p.name + '" class="list-group-item">' + p.id + '--' + p.name + '</li>';
                }
                ulProductList.innerHTML = li;
                productListAreLookingFor.style.display = 'block';
                //them su kien cho li product
                const listGroupProduct = document.querySelectorAll(".list-group-item");
                listGroupProduct.forEach(function(listProduct) {
                    //su kien them 1 product vao ban
                    listProduct.addEventListener('click', function() {
                        let product = this.getAttribute("data-product-type");
                        let [id, name] = product.split('_');
                        dataProductBill[id] = {
                            'id': id,
                            'name': name,
                            'quantity': 0,
                            'original_price': 0,

                        }
                        if (!document.getElementById(id)) {
                            let trProduct = document.createElement('tr');
                            trProduct.setAttribute('id', id)
                            trProduct.innerHTML = '<td style="width: 100px;">' + dataProductBill[id].id + '</td>\
                                <td style="width: 180px;">' + dataProductBill[id].name + '</td>\
                                <td class="text-center" style="width: 90px;"><input id="quantity-' + dataProductBill[id].id + '" type="number" min="0" class=" form-control" value="' + dataProductBill[id].quantity + '"></td>\
                                <td class="text-center" style="width: 150px;"><input id="price-' + dataProductBill[id].id + '" type="number" min="0" class=" form-control" value="' + dataProductBill[id].original_price + '"></td>\
                                <td class="text-center" id="total-' + dataProductBill[id].id + '">' + (dataProductBill[id].quantity * dataProductBill[id].original_price).toLocaleString('vi', { style: 'currency', currency: 'VND' }) + '</td>\
                                <td class="text-center" style="width: 50px;"><i id="btnDelete-' + dataProductBill[id].id + '" class="fas fa-trash"></i></td>';
                            proSearchAppend.appendChild(trProduct);

                            //sua kien thay doi cua input quantity, price va delete
                            let inputQuantity = document.getElementById('quantity-' + dataProductBill[id].id);
                            let inputPrice = document.getElementById('price-' + dataProductBill[id].id);
                            let inputTotal = document.getElementById('total-' + dataProductBill[id].id);
                            let btnDelete = document.getElementById('btnDelete-' + dataProductBill[id].id);
                            inputQuantity.addEventListener('change', function() {
                                dataProductBill[id].quantity = inputQuantity.value;
                                inputTotal.innerHTML = (dataProductBill[id].quantity * dataProductBill[id].original_price).toLocaleString('vi', { style: 'currency', currency: 'VND' });
                                totalPriceAndQuantity();
                            });

                            inputPrice.addEventListener('change', function() {
                                dataProductBill[id].original_price = inputPrice.value;
                                inputTotal.innerHTML = (dataProductBill[id].quantity * dataProductBill[id].original_price).toLocaleString('vi', { style: 'currency', currency: 'VND' });
                                totalPriceAndQuantity();
                            });

                            btnDelete.addEventListener('click', function() {
                                proSearchAppend.removeChild(trProduct);
                                delete dataProductBill[id];
                                totalPriceAndQuantity();
                                console.log(dataProductBill);
                            });

                        }
                        totalPriceAndQuantity();

                        //tinh tong
                        function totalPriceAndQuantity() {
                            let quantity = 0,
                                Total = 0;
                            for (const key in dataProductBill) {

                                quantity += Number(dataProductBill[key]['quantity']);
                                Total += dataProductBill[key]['original_price'] * dataProductBill[key]['quantity'];
                            }
                            totalQuantity.value = quantity;
                            totalPrice.value = Total.toLocaleString('vi', { style: 'currency', currency: 'VND' });
                            inputProductBill.value = JSON.stringify(dataProductBill);
                        }
                    });
                });
            });
    });

    ulProductList.addEventListener('mouseover', cleardisplay1);
    ulProductList.addEventListener('mouseout', cleardisplay2);



    //function

    function cleardisplay1() {
        productListAreLookingFor.style.display = 'block';
    }

    function cleardisplay2() {
        productListAreLookingFor.style.display = 'none';
    }

})();