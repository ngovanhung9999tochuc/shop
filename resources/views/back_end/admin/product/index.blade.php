@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/product/index/index.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách sản phẩm',
    'name'=>'Sản phẩm','key'=>'Danh sách','route'=>route('product.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <a class="btn btn-success btn-sm" style="width: 100px;" href="{{route('product.create')}}"><i class="fas fa-plus"> Thêm mới</i></a>
                            <div class="card-tools">
                                <form method="POST" action="{{route('product.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tên sản phẩm">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->

                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <a class="btn btn-success btn-sm float-right" href="{{route('product.create')}}" style="width: 100px; margin: 0px 20px;"><i class="fas fa-plus"> Thêm mới</i></a>
                            <table id="table-product" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá bán</th>
                                        <th>Khuyến mãi</th>
                                        <th>Hình ảnh</th>
                                        <th>Danh mục</th>
                                        <th>Nhập giá</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td id="td-unit-price-{{$product->id}}">{{number_format($product->unit_price)}}</td>
                                        <td id="td-promotion-price-{{$product->id}}">{{$product->promotion_price}}%</td>
                                        <td><img src="{{ asset($product->image)}}" style="width:100px ; height: 100px;" /></td>
                                        <td>{{$product->productType->productTypeParent->name." ".$product->productType->name}}</td>
                                        <td><button id="price_{{$product->id}}" onclick="enterPrice(this)" class="btn btn-success btn-sm btn-price" style="width: 120px;"><i class="fas fa-plus"> Cập nhật giá</i></button></td>
                                        <td>
                                            <a title="Sửa sản phẩm" class="btn btn-info btn-sm" href="{{route('product.edit',$product->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                            <button title="Xóa" data-url="{{route('product.destroy',$product->id)}}" value="{{$product->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div id="id01" class="modal col-md-12">
                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>

                        <div class="container">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header" style="background-color: #28a745;">
                                            <h3 class="card-title"><b>Thêm giá bán</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-price" method="POST">
                                                @csrf
                                                <h6 class="mt-3 "><b>Giá bán</b></h6>
                                                <div class="input-group mb-3">
                                                    <input type="number" min="0" class="form-control" max="5000000000" value="0" name="unit_price">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Đồng</span>
                                                    </div>

                                                </div>

                                                <h6 class="mt-3 "><b>Khuyến mãi</b></h6>
                                                <div class="input-group mb-3">
                                                    <input type="number" min="0" class="form-control" max="100" value="0" name="promotion_price">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>

                                                </div>
                                                <button type="submit" class="btn btn-primary" style="width: 100px; margin-left: 40%;">Gửi</button>
                                            </form>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- /.row (main row) -->
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('js')
<script>
    $('#table-product').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "order": [],
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
</script>
<script src="{{asset('vendor/jquery-2.2.0.min.js')}}"></script>
<script src="{{asset('Admin/admin/delete.js')}}"></script>
<script>
    let base_url = "{{ asset('') }}";
    base_url = [...base_url];
    base_url.pop();
    base_url = base_url.join("");
    const modal = document.getElementById('id01');
    const formPrice = document.getElementById('form-price');
    let idProduct = '';
    //event
    // When the user clicks anywhere outside of the modal, close it

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    //event 


    function enterPrice(price) {
        let [x, id] = price.id.split('_');
        idProduct = id;
        modal.style.display = "block";
        const tdUnitPrice = document.getElementById('td-unit-price-' + idProduct);
        const tdPromotionPrice = document.getElementById('td-promotion-price-' + idProduct);
        formPrice['unit_price'].value = tdUnitPrice.innerHTML.split('.')[0].replace(/[^0-9]/gi, '');
        formPrice['promotion_price'].value = tdPromotionPrice.innerHTML.replace(/[^0-9]/gi, '');
    }

    formPrice.addEventListener('submit', addProductPrice)


    //function
    function addProductPrice(event) {
        event.preventDefault();
        let _token = this['_token'].value;
        let unitPrice = this['unit_price'].value;
        let promotionPrice = this['promotion_price'].value;
        const tdUnitPrice = document.getElementById('td-unit-price-' + idProduct);
        const tdPromotionPrice = document.getElementById('td-promotion-price-' + idProduct);
        request('{{route("product.price.post")}}', JSON.stringify({
            '_token': _token,
            'unit_price': unitPrice,
            'promotion_price': promotionPrice,
            'id': idProduct
        }), function(data) {
            let result = JSON.parse(data);
            if (result['result']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn thêm giá sản phẩm thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                tdUnitPrice.innerHTML = Number(unitPrice).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                tdPromotionPrice.innerHTML = promotionPrice + '%';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn thêm giá sản phẩm không thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    }

    function request(url = "", para = "", callbackSuccess = function() {}, callbackError = function(err) {
        console.log(err)
    }) {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                callbackSuccess(this.responseText);
            } else if (this.readyState == 4) {
                callbackError(this);
            }
        }
        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/json");
        xmlHttp.send(para);
    }
</script>
</script>
@endsection