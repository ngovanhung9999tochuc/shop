@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/bill/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/bill/index/index1.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách đơn hàng',
    'name'=>'Đơn hàng','key'=>'Danh sách','route'=>route('bill.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-tools row">
                                        <form class="col-md-4" method="POST" action="{{route('bill.search.status')}}">
                                            @csrf @method('post')
                                            <div class=" input-group input-group-sm">
                                                <select name="status" class="form-control">
                                                    <option>Tìm kiếm trình trạng</option>
                                                    <option value="0">Mới</option>
                                                    <option value="1">Xác nhận</option>
                                                    <option value="2">Đang chuyển</option>
                                                    <option value="3">Thành công</option>
                                                    <option value="4">Thất bại</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                        <form method="POST" class=" col-md-8 float-right" action="{{route('bill.search')}}">
                                            @csrf @method('post')
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-3"><b>Từ:</b></div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <div class="input-group-sm">
                                                                    <input name="from" class="form-control" type="date" value="" id="example-date-input1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-3"><b>Đến:</b></div>
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <div class="input-group-sm">
                                                                    <input name="to" class="form-control" type="date" value="" id="example-date-input2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group input-group-sm" style="width: 200px;">
                                                        <input type="text" name="table_search" class="form-control float-right" value="" placeholder="Tìm mã đơn đặt hàng">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <table id="table-bill" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Tên khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trình trạng</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $bill)
                                    <tr>
                                        <td>{{$bill->id}}</td>
                                        <td>{{$bill->date_order}}</td>
                                        <td>{{$bill->user->name}}</td>
                                        <td>{{$bill->phone}}</td>
                                        <td>{{$bill->quantity}}</td>
                                        <td>{{number_format($bill->total)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button style="width: 110px;" type="button" id="btn-text-{{$bill->id}}" class="btn 
                                                @switch($bill->status)
                                                    @case(0)
                                                    btn-primary
                                                    @break

                                                    @case(1)
                                                    btn-info
                                                    @break

                                                    @case(2)
                                                    btn-warning
                                                    @break

                                                    @case(3)
                                                    btn-success
                                                    @break

                                                    @case(4)
                                                    btn-danger
                                                    @break
                                                    @endswitch btn-flat btn-sm">
                                                    @switch($bill->status)
                                                    @case(0)
                                                    Mới
                                                    @break

                                                    @case(1)
                                                    Xác nhận
                                                    @break

                                                    @case(2)
                                                    Đang chuyển
                                                    @break

                                                    @case(3)
                                                    Thành công
                                                    @break

                                                    @case(4)
                                                    Thất bại
                                                    @break
                                                    @endswitch</button>
                                                <button type="button" id="btn-dropdown-{{$bill->id}}" class="btn 
                                                    @switch($bill->status)
                                                    @case(0)
                                                    btn-primary
                                                    @break

                                                    @case(1)
                                                    btn-info
                                                    @break

                                                    @case(2)
                                                    btn-warning
                                                    @break

                                                    @case(3)
                                                    btn-success
                                                    @break

                                                    @case(4)
                                                    btn-danger
                                                    @break
                                                    @endswitch btn-sm btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a id="status-billid_{{$bill->id}}-1" onclick="changeStatus(this)" class="btn-dropdown-status dropdown-item">Xác nhận</a>
                                                        <a id="status-billid_{{$bill->id}}-2" onclick="changeStatus(this)" class="btn-dropdown-status dropdown-item">Đang chuyển</a>
                                                        <a id="status-billid_{{$bill->id}}-3" onclick="changeStatus(this)" class="btn-dropdown-status dropdown-item">Thành công</a>
                                                        <a id="status-billid_{{$bill->id}}-4" onclick="changeStatus(this)" class="btn-dropdown-status dropdown-item">Thất bại</a>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <a id="btn_info-{{$bill->id}}" title="Xem" onclick="showInfo(this)" class="btn-show-info btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <button title="Xóa" data-url="{{route('bill.destroy',$bill->id)}}" value="{{$bill->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="id01" class="modal col-md-12">

                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>

                        <div class="container">
                            <div class="container">
                                <div class="main-body">
                                    <div class="row gutters-sm">
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column align-items-center text-center">
                                                        <img id="image-avata" src="" alt="Admin" class="rounded-circle" width="150">
                                                        <div class="mt-3">
                                                            <h5 id="full-name"></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- fb -->
                                        </div>
                                        <div class="col-md-8">
                                            <div id="content" class="card mb-3">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Số Lượng đơn hàng</th>
                                                        <th>Giá bán</th>
                                                        <!--   <th>Hình ảnh</th> -->
                                                        <th id="th-inventory"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-product">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="id02" class="modal col-md-12">

                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>

                        <div class="container">
                            <div class="container">
                                <div class="main-body">
                                    <div class="row">
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Tồn kho</th>
                                                        <th>Số lượng trong đơn hàng</th>
                                                        <!--  <th>Hình ảnh</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-product-inventory">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script src="{{asset('Admin/admin/delete.js')}}"></script>
<script>
    let _token = document.getElementById('_token');
    $('#table-bill').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "order": [],
        "info": false,
        "autoWidth": false,
        "responsive": true
    });
    //variables
    let arrClass = [{
        'class': 'btn-primary',
        'textStatus': 'Mới'
    }, {
        'class': 'btn-info',
        'textStatus': 'Xác nhận'
    }, {
        'class': 'btn-warning',
        'textStatus': 'Đang chuyển'
    }, {
        'class': 'btn-success',
        'textStatus': 'Thành công'
    }, {
        'class': 'btn-danger',
        'textStatus': ' Thất bại'
    }];
    const base_url = "{{ asset('') }}";
    const btnStatus = document.querySelectorAll('.btn-dropdown-status');
    let modal = document.getElementById('id01');
    let modal2 = document.getElementById('id02');
    let btnShowInfo = document.querySelectorAll('.btn-show-info');
    //event
    window.onclick = function(event) {
        if (event.target == modal || event.target == modal2) {
            modal.style.display = "none";
            modal2.style.display = "none";
        }
    }
    //show info

    function showInfo(info) {
        let [x, id] = info.id.split('-');
        let fullName = document.getElementById('full-name');
        let content = document.getElementById('content');
        let tableProduct = document.getElementById('table-product');
        let imageAvata = document.getElementById('image-avata');

        request('{{route("bill.show")}}', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                let bill = data['bill'];
                let user = bill['user'];
                let products = data['dataProduct'];

                //su ly user
                imageAvata.src = base_url + user['image_icon'];
                fullName.innerHTML = user['name'];
                //su ly thong tin
                let textContent = '';
                textContent += '<div class="card-body">';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Email</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['email'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Địa Chỉ</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['address'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Số Điện Thoại</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['phone'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Ngày Đặt Hàng</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['date_order'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Tổng Số Lượng</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += bill['quantity'];
                textContent += '</div>';
                textContent += '</div>';
                textContent += '<hr>';
                textContent += '<div class="row">';
                textContent += '<div class="col-sm-3">';
                textContent += '<h6 class="mb-0">Tổng Tiền</h6>';
                textContent += '</div>';
                textContent += '<div class="col-sm-9 text-secondary">';
                textContent += Number(bill['total']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
                textContent += '</div>';
                textContent += '</div>';
                textContent += '</div>';
                content.innerHTML = textContent;

                let tr = '';

                for (const product in products) {
                    let color = '';
                    if (products[product]['quantityInventory'] - products[product]['quantityRequired'] <= 0) {
                        color = 'background-color: rgb(250, 74, 74);';
                    }
                    let td = '';
                    td += '<tr>';
                    td += '<td>' + products[product]['id'] + '</td>';
                    td += '<td>' + products[product]['name'] + '</td>';
                    td += '<td>' + products[product]['quantityRequired'] + '</td>';
                    td += '<td>' + Number(products[product]['unit_price']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ' + '</td>';
                    if (bill['status'] == 0) {
                        td += '<td style="' + color + '">' + products[product]['quantityInventory'] + '</td>';
                        document.getElementById('th-inventory').textContent = 'Tồn kho';
                    } else {
                        document.getElementById('th-inventory').textContent = '';
                    }

                    //td += '<td><img src="' + products[product]['image'] + '" style="width:80px ; height: 80px;" /></td>';

                    td += '</tr>';
                    tr += td;
                }
                tableProduct.innerHTML = tr;
                modal.style.display = "block";
            }
        });
    }


    //change status

    //

    function changeStatus(s) {
        let [x, btnId, status] = s.id.split('-');
        let [y, id] = btnId.split('_');
        let tableProductInventory = document.getElementById('table-product-inventory');
        request('{{route("bill.status")}}', JSON.stringify({
            '_token': _token.value,
            'status': status,
            'id': id
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                let status = data['status'];
                const btnText = document.getElementById('btn-text-' + id);
                const btnDropdown = document.getElementById('btn-dropdown-' + id);
                for (const i of arrClass) {
                    btnText.classList.remove(i['class']);
                    btnDropdown.classList.remove(i['class']);
                }
                btnText.innerHTML = arrClass[status]['textStatus'];
                btnText.classList.add(arrClass[status]['class']);
                btnDropdown.classList.add(arrClass[status]['class']);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Kho không đủ sản phẩm để giao hàng',
                    showConfirmButton: false,
                    timer: 4000
                });
                let tr = '';
                let products = data['inventorys']
                for (const product in products) {

                    let td = '';
                    td += '<tr>';
                    td += '<td>' + products[product]['id'] + '</td>';
                    td += '<td>' + products[product]['name'] + '</td>';
                    td += '<td>' + products[product]['quantityInventory'] + '</td>';
                    td += '<td>' + products[product]['quantityRequired'] + '</td>';
                    //td += '<td><img src="' + products[product]['image'] + '" style="width:80px ; height: 80px;" /></td>';
                    td += '</tr>';
                    tr += td;
                }
                tableProductInventory.innerHTML = tr;
                modal2.style.display = "block";
            }
        });
    }





    //function
    function request(url = "", para = "", callbackSuccess = function() {}, callbackError = function(err) {
        console.log(err)
    }) {
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
</script>
@endsection