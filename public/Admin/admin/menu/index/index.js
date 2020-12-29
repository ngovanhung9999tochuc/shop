const base_url = window.location.origin;
const modal = document.getElementById('id01');
const modal2 = document.getElementById('id02');
const btnAddMenu = document.getElementById('btn-add-menu');
const formAddMenu = document.getElementById('form-add-menu');
const formEditMenu = document.getElementById('form-edit-menu');
const trBody = document.getElementById('trbody');
//event
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2) {
        modal.style.display = "none";
        modal2.style.display = "none";

    }
}

btnAddMenu.addEventListener('click', function() {
    const _token = document.getElementById('_token');
    const parentAdd = document.getElementById('parent-add');
    const productTypeLinkAdd = document.getElementById('product-type-link-add');
    modal.style.display = "block";
    clearErrorMessagesAdd();
    formAddMenu.reset();
    request(base_url + '/admin/menu/parent', JSON.stringify({
        '_token': _token.value,
    }), function(data) {
        data = JSON.parse(data);
        console.log(data);
        if (data['success']) {

            let optionParents = data['optionParents'];
            let optionProductType = data['optionProductType'];
            parentAdd.innerHTML = optionParents;
            productTypeLinkAdd.innerHTML = optionProductType;
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

$(document).ready(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#form-add-menu').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesAdd();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/menu/store',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
                this.reset();
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn thêm menu thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let menu = data['menu'];
                    let parent = '';
                    if (menu['menu_parent']) {
                        parent = menu['menu_parent']['name'];
                    }
                    let tr = document.createElement('tr');
                    let dataMenu = '';
                    dataMenu += '<tr>';
                    dataMenu += '<td id="id-' + menu['id'] + '">' + menu['id'] + '</td>';
                    dataMenu += '<td id="name-' + menu['id'] + '">' + menu['name'] + '</td>';
                    dataMenu += '<td id="parent-' + menu['id'] + '">' + parent + '</td>';
                    dataMenu += '<td>';
                    dataMenu += '<button id="btn-edit-' + menu['id'] + '" title="Sửa" onclick="editMenu(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                    dataMenu += '<button title="Xóa" data-url="' + base_url + '/admin/menu/' + menu['id'] + '" value="' + menu['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                    dataMenu += '</td>';
                    dataMenu += '</tr>';
                    tr.innerHTML = dataMenu;
                    trBody.prepend(tr);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn thêm menu không thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                }

            },
            error: function(error) {
                let errors = error.responseJSON['errors'];
                for (const key in errors) {
                    $('#validation-add-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
                }
            }
        });
    });


    $('#form-edit-menu').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesEdit();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/menu/update',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn sửa menu thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let menu = data['menu'];
                    let parent = '';
                    if (menu['menu_parent']) {
                        parent = menu['menu_parent']['name'];
                    }
                    document.getElementById('name-' + menu['id']).innerHTML = menu['name'];
                    document.getElementById('parent-' + menu['id']).innerHTML = parent;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn sửa menu không thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                }

            },
            error: function(error) {
                let errors = error.responseJSON['errors'];
                for (const key in errors) {
                    $('#validation-edit-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
                }
            }
        });
    });
});

//function

function editMenu(edit) {
    const _token = document.getElementById('_token');
    let [x, y, id] = edit.id.split('-');
    modal2.style.display = "block";
    clearErrorMessagesEdit();
    formEditMenu.reset();
    request(base_url + '/admin/menu/edit', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        const parentEdit = document.getElementById('parent-edit');
        const productTypeLinkEdit = document.getElementById('product-type-link-edit');
        data = JSON.parse(data);
        if (data['success']) {
            let optionParents = data['optionParents'];
            let optionProductType = data['optionProductType'];
            let menu = data['menu'];
            parentEdit.innerHTML = optionParents;
            productTypeLinkEdit.innerHTML = optionProductType;
            formEditMenu['id'].value = menu['id'];
            formEditMenu['name'].value = menu['name'];
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



function clearErrorMessagesAdd() {
    document.getElementById('validation-add-name').innerHTML = '';
}

function clearErrorMessagesEdit() {
    document.getElementById('validation-edit-name').innerHTML = '';
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