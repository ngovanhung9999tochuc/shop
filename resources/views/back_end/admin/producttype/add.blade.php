@extends('back_end.layout.layout')
@section('content')
@section('css')
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Thêm mới loại sản phẩm', 'name'=>'producttype',
    'key'=>'add','route'=>route('producttype.index')])
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
                    <form method="POST" action="{{route('producttype.store')}}" enctype="multipart/form-data">
                        @csrf @method('post')
                        <div class="form-group">
                            <label>Tên loại sản phẩm</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="nhập tên loại sản phẩm">
                            @error('name')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Loại sản phẩm cha</label>
                            <select class="form-control" name="parent_id">
                                <option value="0">chọn loại cha</option>
                                {!!$htmlOption!!}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mã</label>
                            <input type="text" name="key_code" class="form-control @error('key_code') is-invalid @enderror" value="{{old('key_code')}}" placeholder="nhập mã loại sản phẩm">
                            @error('key_code')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh loại sản phẩm</label>
                            <input type="file" name="image_file" class="form-control-file @error('image_file') is-invalid @enderror" value=""> @error('image_file')
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