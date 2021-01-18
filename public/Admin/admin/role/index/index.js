//
const base_url = window.location.origin;
const modal = document.getElementById('id01');
const modal2 = document.getElementById('id02');
const modal3 = document.getElementById('id03');
const modal4 = document.getElementById('id04');
const btnAddRole = document.getElementById('btn-add-role');
const formAddRole = document.getElementById('form-add-role');
const formEditRole = document.getElementById('form-edit-role');
const trBody = document.getElementById('trbody');
//event
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2 || event.target == modal3 || event.target == modal4) {
        modal.style.display = "none";
        modal2.style.display = "none";
        modal3.style.display = "none";
        modal4.style.display = "none";
    }
}
btnAddRole.addEventListener('click', function() {
    modal.style.display = "block";
    clearErrorMessagesAdd()
    formAddRole.reset();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('#form-add-role').submit(function(e) {
    e.preventDefault();
    clearErrorMessagesAdd();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: base_url + '/admin/role/store',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            this.reset();
            if (data['success']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn thêm vai trò thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                let role = data['role'];

                let tr = document.createElement('tr');
                let dataRole = '';
                dataRole += '<tr>';
                dataRole += '<td id="id-' + role['id'] + '">' + role['id'] + '</td>';
                dataRole += '<td id="name-' + role['id'] + '">' + role['name'] + '</td>';
                dataRole += '<td id="display-' + role['id'] + '">' + role['display_name'] + '</td>';
                dataRole += '<td><button id="btn-permission-' + role['id'] + '" onclick="grantingPermission(this)" class="btn btn-success btn-sm btn-price" style="width: 120px;"><i class="fas fa-plus"> Phân quyền</i></button></td>';
                dataRole += '<td>';
                dataRole += '<button id="btn-edit-' + role['id'] + '" title="Sửa" onclick="editRole(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                dataRole += '<button title="Xóa" data-url="' + base_url + '/admin/role/' + role['id'] + '" value="' + role['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                dataRole += '</td>';
                dataRole += '</tr>';
                tr.innerHTML = dataRole;
                trBody.prepend(tr);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn thêm vai trò không thành công',
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

$('#form-edit-role').submit(function(e) {
    e.preventDefault();
    clearErrorMessagesEdit();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: base_url + '/admin/role/update',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            if (data['success']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn sửa vai trò thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                let role = data['role'];
                document.getElementById('name-' + role['id']).innerHTML = role['name'];
                document.getElementById('display-' + role['id']).innerHTML = role['display_name'];
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn sửa vai trò không thành công',
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


$('#form-permission-role').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: base_url + '/admin/role/permission/update',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            if (data['success']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn phân quyền thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Quản trị có quyền quản lý cao nhất, không thể sửa đổi',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        },
        error: function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi hệ thống !',
                showConfirmButton: false,
                timer: 4000
            });
        }
    });
});


//function
function editRole(edit) {
    const _token = document.getElementById('_token');
    let [x, y, id] = edit.id.split('-');

    clearErrorMessagesEdit();
    formEditRole.reset();
    request(base_url + '/admin/role/edit', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {
            let role = data['role'];
            formEditRole['id'].value = role['id'];
            formEditRole['name'].value = role['name'];
            formEditRole['display_name'].value = role['display_name'];
            modal2.style.display = "block";
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

function grantingPermission(btnPermission) {
    let [x, y, id] = btnPermission.id.split('-');
    const _token = document.getElementById('_token');
    const listPermission = document.getElementById('list-permissions');
    const roleIdPermissions = document.getElementById('role-id-permissions');

    request(base_url + '/admin/role/permission', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        data = JSON.parse(data);

        if (data['success']) {
            let htmlList = data['htmlList'];
            listPermission.innerHTML = htmlList;
            roleIdPermissions.value = data['id'];
            modal3.style.display = "block";
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