//
const base_url = window.location.origin;
const modal = document.getElementById('id01');
const modal2 = document.getElementById('id02');
const btnAddSlide = document.getElementById('btn-add-slide');
const formAddSlide = document.getElementById('form-add-slide');
const formEditSlide = document.getElementById('form-edit-slide');
const trBody = document.getElementById('trbody');
const image = document.getElementById('image');
const imageEdit = document.getElementById('image-edit');
const outputImageEdit = document.getElementById('output-image-edit');
//event
window.onclick = function(event) {
    if (event.target == modal || event.target == modal2) {
        modal.style.display = "none";
        modal2.style.display = "none";
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


btnAddSlide.addEventListener('click', function() {
    modal.style.display = "block";
    clearErrorMessagesAdd();
    formAddSlide.reset();
});

$(document).ready(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#form-add-slide').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesAdd();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/slide/store',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                this.reset();
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn thêm khuyến mãi thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let slide = data['slide'];
                    let tr = document.createElement('tr');
                    let dataSlide = '';
                    dataSlide += '<tr>';
                    dataSlide += '<td id="id-' + slide['id'] + '" >' + slide['id'] + '</td>';
                    dataSlide += '<td id="title-' + slide['id'] + '" >' + slide['title'] + '</td>';
                    dataSlide += '<td id="description-' + slide['id'] + '" >' + slide['description'] + '</td>';
                    dataSlide += '<td><img id="image-' + slide['id'] + '" src="' + slide['image'] + '" alt="image" style="width:250px ; height: 80px;" /></td>';
                    dataSlide += '<td>';
                    dataSlide += '<button id="btn-edit-' + slide['id'] + '" title="Sửa khuyến mãi" onclick="editSlide(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                    dataSlide += '<button title="Xóa" data-url="' + base_url + '/admin/slide/' + slide['id'] + '" value="' + slide['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                    dataSlide += '</td>';
                    dataSlide += '</tr>';
                    tr.innerHTML = dataSlide;
                    trBody.prepend(tr);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn thêm khuyến mãi không thành công',
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



    $('#form-edit-slide').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesEdit();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/slide/update',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn sửa khuyến mãi thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let slide = data['slide'];
                    document.getElementById('id-' + slide['id']).innerHTML = slide['id'];
                    document.getElementById('title-' + slide['id']).innerHTML = slide['title'];
                    document.getElementById('description-' + slide['id']).innerHTML = slide['description'];
                    document.getElementById('image-' + slide['id']).src = slide['image'];
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn sửa khuyến mãi không thành công',
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

function editSlide(edit) {
    const _token = document.getElementById('_token');
    let [x, y, id] = edit.id.split('-')

    clearErrorMessagesEdit();
    formEditSlide.reset();

    request(base_url + '/admin/slide/edit', JSON.stringify({
        '_token': _token.value,
        'id': id
    }), function(data) {
        data = JSON.parse(data)['slide'];
        formEditSlide['id'].value = data['id'];
        formEditSlide['title'].value = data['title'];
        formEditSlide['description'].value = data['description'];
        formEditSlide['link'].value = data['link'];
        outputImageEdit.src = data['image'];
        outputImageEdit.style.height = '150px';
        outputImageEdit.style.marginTop = '10px';
        modal2.style.display = "block";
    });
}


function clearErrorMessagesAdd() {
    document.getElementById('validation-add-title').innerHTML = '';
    document.getElementById('validation-add-image').innerHTML = '';
}


function clearErrorMessagesEdit() {
    document.getElementById('validation-edit-title').innerHTML = '';
    document.getElementById('validation-edit-image').innerHTML = '';
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