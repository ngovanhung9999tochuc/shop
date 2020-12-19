@extends('back_end.layout.layout')
@section('content')
@section('css')
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Thêm mới nhà cung ứng', 'name'=>'supplier',
    'key'=>'add','route'=>route('supplier.index')])
    <!-- /.content-header -->
    <div class="col-md-12">

    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <form method="POST" action="{{route('supplier.store')}}" enctype="multipart/form-data">
                        @csrf @method('post')
                        <div class="form-group">
                            <label>Tên nhà cung ứng</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="nhập tên nhà cung ứng">
                            @error('name')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="nhập email">
                            @error('email')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="nhập đỉa chỉ">
                            @error('address')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" placeholder="nhập số điện thoại">
                            @error('phone')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button style="width: 100px; margin-left: 40%;" type="submit" class="btn btn-primary">Gửi</button>
                    </form>
                </div>
            </div>


        </div>
    </section>
    <!-- /.content -->
</div>
@endsection @section('js')

@php
if(Session::has('message')){
echo Session::get('message');
}
@endphp
@endsection