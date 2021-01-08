(function() {
    //
    const base_url = window.location.origin;
    const _token = document.getElementById('_token');
    let modal = document.getElementById('id01');
    let btnShowInfo = document.querySelectorAll('.btn-show-info');
    //event
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


    //event
    btnShowInfo.forEach(function(btn) {
        btn.addEventListener('click', function() {
            let [x, id] = this.id.split('-');
            let tableProduct = document.getElementById('table-product');
            request(base_url + '/admin/billin/show', JSON.stringify({
                '_token': _token.value,
                'id': id
            }), function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    let bill = data['bill'];
                    let products = bill['products'];
                    let tr = '';
                    for (const product of products) {
                        let td = '';
                        td += '<tr>';
                        td += '<td>' + product['id'] + '</td>';
                        td += '<td>' + product['name'] + '</td>';
                        td += '<td>' + product['pivot']['quantity'] + '</td>';
                        td += '<td>' + Number(product['pivot']['original_price']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + '</td>';
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
})()