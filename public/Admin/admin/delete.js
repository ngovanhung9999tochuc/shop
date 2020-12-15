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
        text: "Dữ liệu sẽ mất không thể phục hồi !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
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