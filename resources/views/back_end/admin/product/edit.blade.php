@extends('back_end.layout.layout') @section('content') @section('css') @endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Sửa sản phẩm', 'name'=>'Sản phẩm','key'=>'Sửa','route'=>route('product.index')])
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
                    <form method="POST" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
                        @csrf @method('put')
                        <div class="form-group">
                            <label>Tên sản phẩm*</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$product->name}}" placeholder="nhập tên sản phẩm">
                            @error('name')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>CPU*</label>
                            <input type="text" name="cpu" class="form-control @error('cpu') is-invalid @enderror" value="{{$product->specifications['cpu']}}" placeholder="nhập CPU">
                            @error('cpu')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>RAM*</label>
                            <input type="text" name="ram" class="form-control @error('ram') is-invalid @enderror" value="{{$product->specifications['ram']}}" placeholder="nhập RAM">
                            @error('ram')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Màn hình*</label>
                            <input type="text" name="displayscreen" class="form-control @error('displayscreen') is-invalid @enderror" value="{{$product->specifications['displayscreen']}}" placeholder="nhập màn hình">
                            @error('displayscreen')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Bộ nhớ trong/Ổ cứng*</label>
                            <input type="text" name="rom_harddrive" class="form-control @error('rom_harddrive') is-invalid @enderror" value="{{$product->specifications['rom_harddrive']}}" placeholder="nhập bộ nhớ trong/ổ cứng">
                            @error('rom_harddrive')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Hệ điều hành*</label>
                            <input type="text" name="operatingsystem" class="form-control @error('operatingsystem') is-invalid @enderror" value="{{$product->specifications['operatingsystem']}}" placeholder="nhập hệ điều hành">
                            @error('operatingsystem')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Danh mục*</label>
                            <select class="form-control" name="product_type">
                                {!!$htmlOption!!}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nhà sản xuất*</label>
                            <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{$product->publisher}}" placeholder="nhập tên nhà sản xuất">
                            @error('publisher')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh sản phẩm*</label>
                            <input type="file" id="image-file" name="image_file" class="form-control-file @error('image_file') is-invalid @enderror" value=""> @error('image_file')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="col-md-12">
                                <div class="row">
                                    <img src="{{ asset($product->image)}}" id="output-image-file"  style="width: 150px; height: 150px;margin-top: 10px;" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Hình ảnh chi tiết</label>
                            <input type="file" id="detailed-image-file" name="detailed_image_file[]" multiple="multiple" class="form-control-file @error('detailed_image_file') is-invalid @enderror" value=""> @error('detailed_image_file')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="col-md-12" style="margin-top: 10px;">
                                <div id="output-detailed-image-file" class="row">
                                    @foreach($product->productImages as $image)
                                    <img style="margin-left: 10px; width: 100px; height: 100px;" src="{{ asset($image->image)}}" alt="" />
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Miêu tả</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{$product->description}}</textarea>
                            @error('description')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Thông số kỹ thuật</label>
                            <textarea id="specifications-all" class="form-control @error('specifications_all') is-invalid @enderror" name="specifications_all">{{$product->specifications_all}}</textarea>
                            @error('specifications_all')
                            <br />
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100px; margin-left: 40%;">Gửi</button>
                    </form>
                </div>
            </div>


        </div>
    </section>
    <!-- /.content -->
</div>
@endsection @section('js')
<script>
    $('#description').summernote();
    $('#specifications-all').summernote();
    const imageFile = document.getElementById('image-file');
    const detailedImageFile = document.getElementById('detailed-image-file');


    //event
    imageFile.addEventListener('change', function() {
        const outputImageFile = document.getElementById('output-image-file');
        outputImageFile.src = URL.createObjectURL(this.files[0]);
        outputImageFile.style.height = '150px';
        outputImageFile.style.width = '150px';
        outputImageFile.style.marginTop = '10px';
    });


    detailedImageFile.addEventListener('change', function() {
        const outputDetailedImageFile = document.getElementById('output-detailed-image-file');
        outputDetailedImageFile.innerHTML = '';
        let totalfiles = detailedImageFile.files.length;
        for (let index = 0; index < totalfiles; index++) {
            let img = document.createElement('img');
            img.src = URL.createObjectURL(detailedImageFile.files[index]);
            img.style.height = '100px';
            img.style.width = '100px';
            img.style.marginLeft = '10px';
            outputDetailedImageFile.appendChild(img);
        }
    });
</script>
@php
if(Session::has('message')){
echo Session::get('message');
}
@endphp
@endsection