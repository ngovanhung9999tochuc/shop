@extends('back_end.layout.layout')
@section('content')
@section('css')


@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách phiếu nhập kho',
    'name'=>'bill','key'=>'list','route'=>route('billin.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nhà cung ứng</th>
                                        <th>Ngày nhập</th>
                                        <th>Số Lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bill_ins as $bill)
                                    <tr>
                                        <td>{{$bill->id}}</td>
                                        <td>{{$bill->supplier->name}}</td>
                                        <td>{{date("m/d/y g:i A", strtotime($bill->input_date))}}</td>
                                        <td>{{$bill->quantity}}</td>
                                        <td>{{number_format($bill->total_price)}}đ</td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{route('billin.show',$bill->id)}}"><i class="fas fa-search-plus"></i></a>
                                            <button data-url="{{route('billin.destroy',$bill->id)}}" value="{{$bill->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$bill_ins->links()}}
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script src="{{asset('Admin/admin/delete.js')}}"></script>
@endsection