function actionDelete(event) {
    event.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let id = document.getElementById('btn_delete').value;
    let urlRequest = $(this).data('url');
    let that = $(this);
    Swal.fire({
        title: 'Bạn có muốn xóa không ?',
        text: "Dữ liệu sẽ không thể phục hồi !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Hủy',
        confirmButtonText: 'Xóa'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlRequest,
                type: 'DELETE', // Just delete Latter Capital Is Working Fine
                dataType: "JSON",
                data: {
                    "id": id // method and token not needed in data
                },
                success: function(data) {
                    if (data.code == 200) {
                        that.parent().parent().remove();
                        Swal.fire(
                            'Đã xóa',
                            'Dữ liệu đã bị xóa',
                            'success'
                        );
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                        let tableProductOrProductType = document.getElementById('table-product-or-product-type');
                        let tr = '';
                        let products = data['data']
                        for (const product in products) {
                            let td = '';
                            td += '<tr>';
                            td += '<td>' + products[product]['id'] + '</td>';
                            td += '<td>' + products[product]['name'] + '</td>';
                            td += '<td>' + products[product]['username'] + '</td>';
                            td += '</tr>';
                            tr += td;
                        }
                        tableProductOrProductType.innerHTML = tr;
                        modal4.style.display = "block";
                    }
                },
                error: function(e) {
                    console.log(e);
                    Swal.fire(
                        'Xóa không thành công',
                        'Lỗi hệ thống',
                        'error'
                    );
                }
            });
        }
    })
}


$(function() {
    $(document).on('click', '.action_delete', actionDelete);
});