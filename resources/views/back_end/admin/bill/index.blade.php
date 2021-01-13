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
                                                        <th>Số Lượng</th>
                                                        <th>Giá bán</th>
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
                                                        <th>Hình ảnh</th>
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
<script src="{{asset('Admin/admin/bill/index/index.js')}}"></script>
<script>
    $('#table-bill').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        'order': [[0, 'desc']]
    });
</script>
@endsection