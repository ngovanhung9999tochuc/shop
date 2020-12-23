(function() {
    //
    var base_url = window.location.origin;
    let btnAddSupplier = document.getElementById('btn-add-supplier');
    const modal = document.getElementById('id01');
    const formSupplier = document.getElementById('form-supplier');
    const _tokenGlobal = document.getElementById('_token').value;
    //event
    getSuppliers();

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    btnAddSupplier.addEventListener('click', function() {
        modal.style.display = "block";
        clearErrorMessages()
        clearFormValue();
    });



    formSupplier.addEventListener('submit', function(event) {
        event.preventDefault();
        clearErrorMessages()
        let _token = this['_token'].value;
        let name = this['name'].value;
        let email = this['email'].value;
        let address = this['address'].value;
        let phone = this['phone'].value;

        request(base_url + '/admin/supplier/store', JSON.stringify({
            '_token': _token,
            'name': name,
            'email': email,
            'address': address,
            'phone': phone
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn thêm nhà cung cấp thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                clearFormValue();
                getSuppliers();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn thêm nhà cung cấp không thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
            }

        }, function(error) {
            let errors = JSON.parse(error)['errors'];
            for (const key in errors) {
                $('#validation-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
            }
        });

    });


    //function
    function getSuppliers() {
        let selectSupplers = document.getElementById('select-supplers');
        request(base_url + '/admin/billin/supplier', JSON.stringify({
                '_token': _tokenGlobal
            }),
            function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    let suppliers = data['suppliers'];
                    let dataSupplier = '<option value="">Chọn nhà cung ứng</option>';
                    for (const supplier of suppliers) {
                        dataSupplier += '<option value="' + supplier['id'] + '">' + supplier['name'] + '</option>';
                    }
                    selectSupplers.innerHTML = dataSupplier;
                }
            });
    }


    function clearErrorMessages() {
        document.getElementById('validation-name').innerHTML = '';
        document.getElementById('validation-email').innerHTML = '';
        document.getElementById('validation-phone').innerHTML = '';
        document.getElementById('validation-address').innerHTML = '';
    }

    function clearFormValue() {
        formSupplier['name'].value = '';
        formSupplier['email'].value = '';
        formSupplier['address'].value = '';
        formSupplier['phone'].value = '';
    }

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
})();