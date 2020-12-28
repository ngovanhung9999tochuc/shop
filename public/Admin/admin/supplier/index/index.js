//
var base_url = window.location.origin;
let btnAddSupplier = document.getElementById('btn-add-supplier');
const modal = document.getElementById('id01');
const modal2 = document.getElementById('id02');
const formSupplier = document.getElementById('form-supplier');
const formSupplierEdit = document.getElementById('form-supplier-edit');
const trBody = document.getElementById('trbody');

//event
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2) {
        modal.style.display = "none";
        modal2.style.display = "none";
    }
}

btnAddSupplier.addEventListener('click', function() {
    modal.style.display = "block";
    clearErrorMessages()
    formSupplier.reset();
});

formSupplierEdit.addEventListener('submit', function(event) {
    event.preventDefault();
    clearErrorMessagesEdit();
    let _token = this['_token'].value;
    let name = this['name'].value;
    let id = this['id'].value;
    let email = this['email'].value;
    let address = this['address'].value;
    let phone = this['phone'].value;
    request(base_url + '/admin/supplier/update', JSON.stringify({
        '_token': _token,
        'name': name,
        'id': id,
        'email': email,
        'address': address,
        'phone': phone
    }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
            Swal.fire({
                icon: 'success',
                title: 'Bạn sửa nhà cung cấp thành công',
                showConfirmButton: false,
                timer: 4000
            });
            let supplier = data['supplier'];
            document.getElementById('name-' + supplier['id']).innerHTML = supplier['name'];
            document.getElementById('email-' + supplier['id']).innerHTML = supplier['email'];
            document.getElementById('address-' + supplier['id']).innerHTML = supplier['address'];
            document.getElementById('phone-' + supplier['id']).innerHTML = supplier['phone'];
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi hệ thống ! bạn sửa nhà cung cấp không thành công',
                showConfirmButton: false,
                timer: 4000
            });
        }

    }, function(error) {
        let errors = JSON.parse(error)['errors'];
        console.log(errors);
        for (const key in errors) {
            $('#validation-edit-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
        }
    });
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
            formSupplier.reset();
            let supplier = data['supplier'];
            let tr = document.createElement('tr');
            let dataSupplier = '';
            dataSupplier += '<tr>';
            dataSupplier += '<td id="id-' + supplier['id'] + '">' + supplier['id'] + '</td>';
            dataSupplier += '<td id="name-' + supplier['id'] + '">' + supplier['name'] + '</td>';
            dataSupplier += '<td id="email-' + supplier['id'] + '">' + supplier['email'] + '</td>';
            dataSupplier += '<td id="address-' + supplier['id'] + '">' + supplier['address'] + '</td>';
            dataSupplier += '<td id="phone-' + supplier['id'] + '">' + supplier['phone'] + '</td>';
            dataSupplier += '<td>';
            dataSupplier += '<button id="btn-edit-' + supplier['id'] + '" title="Sửa nhà cung cấp" onclick="editSupplier(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
            dataSupplier += '<button title="Xóa" data-url="' + base_url + '/admin/supplier/' + supplier['id'] + '" value="' + supplier['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
            dataSupplier += '</td>';
            dataSupplier += '</tr>';
            tr.innerHTML = dataSupplier;
            trBody.prepend(tr);
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

function editSupplier(edit) {
    const _token = document.getElementById('_token');
    modal2.style.display = "block";
    clearErrorMessagesEdit();
    formSupplierEdit.reset();
    let [x, y, id] = edit.id.split('-');
    request(base_url + '/admin/supplier/edit', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        data = JSON.parse(data)['supplier'];
        formSupplierEdit['id'].value = data['id'];
        formSupplierEdit['name'].value = data['name'];
        formSupplierEdit['email'].value = data['email'];
        formSupplierEdit['address'].value = data['address'];
        formSupplierEdit['phone'].value = data['phone'];
    });
}


function clearErrorMessages() {
    document.getElementById('validation-name').innerHTML = '';
    document.getElementById('validation-email').innerHTML = '';
    document.getElementById('validation-phone').innerHTML = '';
    document.getElementById('validation-address').innerHTML = '';
}

function clearErrorMessagesEdit() {
    document.getElementById('validation-edit-name').innerHTML = '';
    document.getElementById('validation-edit-email').innerHTML = '';
    document.getElementById('validation-edit-address').innerHTML = '';
    document.getElementById('validation-edit-phone').innerHTML = '';
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