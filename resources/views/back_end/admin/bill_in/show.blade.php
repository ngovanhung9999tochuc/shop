@extends('back_end.layout.layout')
@section('content')
@section('css')


@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách sản phẩm phiếu nhập',
    'name'=>'bill','key'=>'show','route'=>route('billin.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Mã phiếu nhập</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Số Lượng</th>
                                        <th>Giá nhập</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bill_in_details as $bill_details)
                                    <tr>
                                        <td>{{$bill_details->pivot->bill_in_id}}</td>
                                        <td>{{$bill_details->name}}</td>
                                        <td><img src="{{$bill_details->image}}" style="width:100px ; height: 100px;" /></td>
                                        <td>{{$bill_details->pivot->quantity}}</td>
                                        <td>{{number_format($bill_details->pivot->original_price)}}đ</td>
                                        <td>{{number_format($bill_details->pivot->original_price*$bill_details->pivot->quantity)}}đ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$bill_in_details->links()}}
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
<script src="{{asset('Admin/admin/delete.js')}}"></script>
@endsection