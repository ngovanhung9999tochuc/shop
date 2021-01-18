const base_url = window.location.origin;
const modal = document.getElementById('id01');
const modal2 = document.getElementById('id02');
const modal3 = document.getElementById('id03');
const btnAddType = document.getElementById('btn-add-type');
const formAddType = document.getElementById('form-add-type');
const formEditType = document.getElementById('form-edit-type');
const trBody = document.getElementById('trbody');

const image = document.getElementById('image');
const imageEdit = document.getElementById('image-edit');
const outputImageEdit = document.getElementById('output-image-edit');
//event
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2 || event.target == modal3) {
        modal.style.display = "none";
        modal2.style.display = "none";
        modal3.style.display = "none";
    }
}
image.addEventListener('change', function() {
    const outputImage = document.getElementById('output-image');
    outputImage.src = URL.createObjectURL(this.files[0]);
    outputImage.style.height = '150px';
    outputImage.style.marginTop = '10px';
});

imageEdit.addEventListener('change', function() {
    outputImageEdit.src = URL.createObjectURL(this.files[0]);
    outputImageEdit.style.height = '150px';
    outputImageEdit.style.marginTop = '10px';
});

btnAddType.addEventListener('click', function() {
    const _token = document.getElementById('_token');
    const parentId = document.getElementById('parent_id');
    modal.style.display = "block";
    clearErrorMessagesAdd();
    formAddType.reset();
    request(base_url + '/admin/producttype/parent', JSON.stringify({
        '_token': _token.value,
    }), function(data) {
        data = JSON.parse(data);
        if (data['success']) {

            let option = data['htmlOption'];
            parentId.innerHTML = option;
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
    $('#form-add-type').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesAdd();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/producttype/store',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                this.reset();
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn thêm danh mục thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let productType = data['productType'];
                    let icon = '',
                        parent = '';
                    if (productType['icon']) {
                        icon = '<img  src="' + productType['icon'] + '" alt="icon" style="width:200px ; height: 50px;" />';
                    }

                    if (productType['product_type_parent']) {
                        parent = productType['product_type_parent']['name'];
                    }
                    let tr = document.createElement('tr');
                    let dataType = '';
                    dataType += '<tr>';
                    dataType += '<td id="id-' + productType['id'] + '">' + productType['id'] + '</td>';
                    dataType += '<td id="name-' + productType['id'] + '">' + productType['name'] + '</td>';
                    dataType += '<td id="icon-' + productType['id'] + '">' + icon + '</td>';
                    dataType += '<td id="parent-' + productType['id'] + '">' + parent + '</td>';
                    dataType += '<td>';
                    dataType += '<button id="btn-edit-' + productType['id'] + '" title="Sửa" onclick="editProductType(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                    dataType += '<button title="Xóa" data-url="' + base_url + '/admin/producttype/' + productType['id'] + '" value="' + productType['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                    dataType += '</td>';
                    dataType += '</tr>';
                    tr.innerHTML = dataType;
                    trBody.prepend(tr);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn thêm danh mục không thành công',
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



    $('#form-edit-type').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesEdit();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/producttype/update',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn sửa danh mục thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let productType = data['productType'];
                    let icon = '',
                        parent = '';
                    if (productType['icon']) {
                        icon = '<img  src="' + productType['icon'] + '" alt="icon" style="width:200px ; height: 50px;" />';
                    }

                    if (productType['product_type_parent']) {
                        parent = productType['product_type_parent']['name'];
                    }
                    document.getElementById('id-' + productType['id']).innerHTML = productType['id'];
                    document.getElementById('name-' + productType['id']).innerHTML = productType['name'];
                    document.getElementById('parent-' + productType['id']).innerHTML = parent;
                    document.getElementById('icon-' + productType['id']).innerHTML = icon;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống !',
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

function editProductType(edit) {
    const _token = document.getElementById('_token');
    let [x, y, id] = edit.id.split('-');

    clearErrorMessagesEdit();
    formEditType.reset();

    request(base_url + '/admin/producttype/edit', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        const parentEdit = document.getElementById('parent-edit');

        data = JSON.parse(data);
        if (data['success']) {
            let option = data['htmlOption'];
            let productType = data['productType'];
            parentEdit.innerHTML = option;
            formEditType['id'].value = productType['id'];
            formEditType['name'].value = productType['name'];
            outputImageEdit.src = productType['icon'];
            outputImageEdit.style.height = '60px';
            outputImageEdit.style.width = '200px';
            outputImageEdit.style.marginTop = '10px';
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


function clearErrorMessagesAdd() {
    document.getElementById('validation-add-name').innerHTML = '';
    document.getElementById('validation-add-image_file').innerHTML = '';
}

function clearErrorMessagesEdit() {
    document.getElementById('validation-edit-name').innerHTML = '';
    document.getElementById('validation-edit-image_file').innerHTML = '';
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