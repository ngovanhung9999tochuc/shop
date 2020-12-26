(function() {
    $(function() {
        $('.select2_init').select2({});

    });

    $('.select-roles').on('change', function() {
        let selected = $(this).find("option:selected");
        let arrSelected = [];
        let id = this.id;
        selected.each(function() {
            arrSelected.push($(this).val());
        });
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'admin/user/role',
            method: "POST",
            dataType: "JSON",
            data: {
                'id': id,
                'role_ids': arrSelected,
                '_token': _token
            },
            success: function(data) {
                console.log(data);
            }
        });
    });

    //info
    // Get the modal
    let modal = document.getElementById('id01');
    let btnShowInfo = document.querySelectorAll('.btn-show-info');
    btnShowInfo.forEach(function(btn) {
        btn.addEventListener('click', function() {
            let [x, id] = this.id.split('_');
            let _token = $('input[name="_token"]').val();
            let fullName = document.getElementById('full-name');
            let roles = document.getElementById('roles');
            let content = document.getElementById('content');
            let imageAvata = document.getElementById('image-avata');
            $.ajax({
                url: 'admin/user/show',
                method: "POST",
                dataType: "JSON",
                data: {
                    'id': id,
                    '_token': _token
                },
                success: function(data) {
                    let textContent = '';
                    textContent += '<div class="card-body">';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Họ Tên</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['name'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Email</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['email'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Địa Chỉ</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['address'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Số Điện Thoại</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['phone'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Ngày Sinh</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['date_of_birth'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Giới Tính</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['gender'] == 1 ? 'Nam' : 'Nữ';
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Tài Khoản</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['username'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '</div>';
                    let textRoles = '';
                    for (const i of data[1]) {
                        textRoles += i['display_name'] + ', ';
                    }

                    imageAvata.src = data[0]['image_icon'];
                    fullName.innerHTML = data[0]['name'];
                    roles.innerHTML = textRoles.substring(0, textRoles.length - 2);
                    content.innerHTML = textContent;
                    modal.style.display = "block";
                }
            });

        });
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
})();