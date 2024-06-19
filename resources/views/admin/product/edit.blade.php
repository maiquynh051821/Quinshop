<?php
use App\Http\Controllers\Admin\ProductController;
?>
@extends('admin.main')
@section('head')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
    <form action="{{ route('update_product') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $product->id }}" name="product_id">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control" id="name"
                    placeholder="Nhập tên sản phẩm">
            </div>
            <div class="form-group">
                <label>Danh mục</label>
                <select name="menu_id" id="" class="form-control">
                    @foreach ($menus as $menu)
                        <option value="{{ $menu->id }}" {{ $product->menu_id == $menu->id ? 'selected' : '' }}>
                            {{ $menu->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="price">Giá gốc</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-control" id="price"
                    min="1">
            </div>
            <div class="form-group">
                <label for="price_sale">Giá sale</label>
                <input type="number" name="price_sale" value="{{ $product->price_sale }}" class="form-control"
                    id="price_sale" min="1">
            </div>
            <div class="form-group">
                <label for="description">Mô tả chi tiết</label>
                <textarea name="description" id="description" class="form-control">{{ $product->description }} </textarea>
            </div>
            <div class="form-group">
                <label for="content">Cách bảo quản</label>
                <textarea name="content" id="content" class="form-control">{{ $product->content }} </textarea>
            </div>
            <div class="form-group">
                <label for="">Ảnh sản phẩm</label><br>
                <input name="file_img[]" type="file" id="upload" class="form-control" multiple> 
                <?php
                 $thumbs = json_decode($product->thumb);
                    $firstThumb = $thumbs[0] ?? null;   
                    $oneThumb = $thumbs[1] ?? null;
                    $twoThumb = $thumbs[2] ?? null;
                    if(isset($thumbs[3])){
                        $threeThumb = $thumbs[3] ?? null; 
                    }else{
                        $threeThumb = '';
                    }
                ?>
                <div>
                        <img src="{{ asset($firstThumb) }}" alt="" width="100px">
                        <img src="{{ asset($oneThumb) }}" alt="" width="100px">
                        <img src="{{ asset($oneThumb) }}" alt="" width="100px">
                        <img src="{{ asset($threeThumb) }}" alt="" width="100px">
                </div>

                <?php
                $sizeCollection = ProductController::getSizeByProductIdSize($product->id);
                $size = $sizeCollection->toArray();
                ?>
                <div class="form-group">
                    <label class="ms-4" for="">Chọn Size</label>
                    <select multiple class="ms-4" name="size[]" id="">
                        <option value="S" <?php echo in_array("S", $size) ? 'selected' : ''; ?>>S</option>
                        <option value="M" <?php echo in_array("M", $size) ? 'selected' : ''; ?>>M</option>
                        <option value="L" <?php echo in_array("L", $size) ? 'selected' : ''; ?>>L</option>
                        <option value="XL" <?php echo in_array("XL", $size) ? 'selected' : ''; ?>>XL</option>
                        <option value="XXL" <?php echo in_array("XXL", $size) ? 'selected' : ''; ?>>XXL</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="">Kích hoạt</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-5">
                        <input class="custom-control-input" type="radio" id="active" name="active" value="1"
                            {{ $product->active == 1 ? 'checked=""' : '' }}>
                        <label for="active" class="custom-control-label">Có</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="no_active" name="active" value="0"
                            {{ $product->active == 0 ? 'checked=""' : '' }}>
                        <label for="no_active" class="custom-control-label">Không</label>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    {{-- Tạo ckeditor cho mục mô tả chi tiết --}}
    <script>
        CKEDITOR.replace('content');
        CKEDITOR.replace('description');
    </script>
@endsection
