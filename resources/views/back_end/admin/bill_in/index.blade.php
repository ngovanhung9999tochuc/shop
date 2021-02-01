@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/bill_in/index/index.css')}}" rel="stylesheet" />

@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách phiếu nhập kho',
    'name'=>'Nhập kho','key'=>'Danh sách','route'=>route('billin.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <a class="btn btn-success btn-sm" style="width: 100px;" href="{{route('billin.create')}}"><i class="fas fa-plus"> Thêm mới</i></a>
                            <div class="card-tools">
                                <form method="POST" action="{{route('billin.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã phiếu nhập">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->

                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <a class="btn btn-success btn-sm float-right" style="width: 100px; margin: 0px 20px;" href="{{route('billin.create')}}"><i class="fas fa-plus"> Thêm mới</i></a>
                            <table id="table-bill-in" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ngày nhập</th>
                                        <th>Nhà cung cấp</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Người nhập</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bill_ins as $bill)
                                    <tr>
                                        <td>{{$bill->id}}</td>
                                        <td>{{date("Y/m/d", strtotime($bill->input_date))}}</td>
                                        <td>{{$bill->supplier->name}}</td>
                                        <td>{{$bill->quantity}}</td>
                                        <td>{{number_format($bill->total_price)}}</td>
                                        <td>{{$bill->user->name}}</td>
                                        <td>
                                            <a id="btn_info-{{$bill->id}}" title="Xem" class="btn-show-info btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <!-- <button title="Xóa" data-url="{{route('billin.destroy',$bill->id)}}" value="{{$bill->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                <div id="id01" class="modal col-md-12">

                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
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
                                                        <th>Số Lượng</th>
                                                        <th>Giá nhập</th>
                                                        <th>Hình ảnh</th>
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
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script src="{{asset('Admin/admin/delete.js')}}"></script>
<!-- <script src="{{asset('Admin/admin/bill_in/index/index.js')}}"></script> -->
<script>
    $(function() {
        $('#table-bill-in').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "order": [],
            "info": false,
            "autoWidth": false,
            "responsive": true
        });
    });
    let base_url = "{{ asset('') }}";
    base_url = [...base_url];
    base_url.pop();
    base_url = base_url.join("");
    const _token = document.getElementById('_token');
    let modal = document.getElementById('id01');
    let btnShowInfo = document.querySelectorAll('.btn-show-info');
    //event
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


    //event
    btnShowInfo.forEach(function(btn) {
        btn.addEventListener('click', function() {
            let [x, id] = this.id.split('-');
            let tableProduct = document.getElementById('table-product');
            request('{{route("billin.show")}}', JSON.stringify({
                '_token': _token.value,
                'id': id
            }), function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    let bill = data['bill'];
                    let products = bill['products'];
                    let tr = '';
                    for (const product of products) {
                        let td = '';
                        td += '<tr>';
                        td += '<td>' + product['id'] + '</td>';
                        td += '<td>' + product['name'] + '</td>';
                        td += '<td>' + product['pivot']['quantity'] + '</td>';
                        td += '<td>' + Number(product['pivot']['original_price']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ' + '</td>';
                        td += '<td><img src="' + base_url + product['image'] + '" style="width:80px ; height: 80px;" /></td>';
                        td += '</tr>';
                        tr += td;
                    }
                    tableProduct.innerHTML = tr;
                    modal.style.display = "block";
                }
            });
        });
    });


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