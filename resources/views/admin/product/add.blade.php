@extends('admin.main')

@section('head')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
<style>
  .img-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .img-preview img {
            max-width: 150px;
            max-height: 150px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 5px;
        }
</style>
<form id="form_product" action="{{ route('store_product') }}" method="POST" enctype="multipart/form-data">
  @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="name">Tên sản phẩm</label>
        <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Nhập tên sản phẩm" required>
      </div>
      <div class="form-group">
        <label>Danh mục</label>
        <select name="menu_id" id="" class="form-control">
            @foreach ($menus as $menu)
            <option value="{{$menu->id}}">{{$menu->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
      <label for="price">Giá gốc</label>
      <input type="number" name="price" value="{{old('price')}}" class="form-control" id="price" min="1" required>
    </div>
    <div class="form-group">
      <label for="price_sale">Giá sale</label>
      <input type="number" name="price_sale" value="{{old('price_sale')}}" class="form-control" id="price_sale" min="1" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả chi tiết</label>
        <textarea name="description" id="description" class="form-control" required>{{old('description')}}</textarea>
      </div>
      <div class="form-group">
        <label for="content">Cách bảo quản</label>
        <textarea name="content" id="content" class="form-control" required>{{old('content')}} </textarea>
      </div>
      <div class="form-group">
        <label for="">Ảnh sản phẩm</label><br>
        <input required name="file_img[]" type="file" id="upload" class="form-control" multiple> 
      </div>
      <div class="img-preview" id="imgPreview"></div>
      <div class="form-group">
        <label class="ms-4" for="">Chọn Size</label>
        <div class="ms-4 d-flex align-items-center font-weight-bold">
            <div class="form-check mr-3 d-flex align-items-center">
                <input class="form-check-input" type="checkbox" name="size[]" value="S" id="sizeS">
                <label class="form-check-label" for="sizeS">S</label>
            </div>
            <div class="form-check mr-3 d-flex align-items-center">
                <input class="form-check-input" type="checkbox" name="size[]" value="M" id="sizeM">
                <label class="form-check-label" for="sizeM">M</label>
            </div>
            <div class="form-check mr-3 d-flex align-items-center">
                <input class="form-check-input " type="checkbox" name="size[]" value="L" id="sizeL">
                <label class="form-check-label" for="sizeL">L</label>
            </div>
            <div class="form-check mr-3 d-flex align-items-center">
                <input class="form-check-input " type="checkbox" name="size[]" value="XL" id="sizeXL">
                <label class="form-check-label" for="sizeXL">XL</label>
            </div>
            <div class="form-check mr-3 d-flex align-items-center">
                <input class="form-check-input " type="checkbox" name="size[]" value="XXL" id="sizeXXL">
                <label class="form-check-label" for="sizeXXL">XXL</label>
            </div>
        </div>
    </div>
      <div class="">
        <label for="">Kích hoạt</label>
        <div class="d-flex">
            <div class="custom-control custom-radio mr-5">
                <input class="custom-control-input" type="radio" id="active" name="active" value="1" checked> 
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="no_active" name="active" value="0">
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>
      </div>
      
    </div>
    <div class="card-footer">
      <div id="alert-placeholder"></div>
      <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
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
{{-- kiểm tra xem giá và giá sale  --}}
<script>

document.getElementById('upload').addEventListener('change', function(event) {
            var files = event.target.files;
            var imgPreview = document.getElementById('imgPreview');
            
            // Clear previous images
            imgPreview.innerHTML = '';

            // Loop through files and create image elements
            for (var i = 0; i < files.length; i++) {
                var file = files[i];

                if (file.type.match('image.*')) {
                    var reader = new FileReader();

                    reader.onload = (function(theFile) {
                        return function(e) {
                            var imgElement = document.createElement('img');
                            imgElement.src = e.target.result;
                            imgElement.title = theFile.name;
                            imgPreview.appendChild(imgElement);
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            }
        });

  document.getElementById('form_product').addEventListener('submit', function(event) {
      var price = document.getElementById('price').value;
      var priceSale = document.getElementById('price_sale').value;
      var alertPlaceholder = document.getElementById('alert-placeholder');

      // Clear previous alert
      alertPlaceholder.innerHTML = '';

      if (parseFloat(price) <= parseFloat(priceSale)) {
          var alertDiv = document.createElement('div');
          alertDiv.className = 'alert alert-danger';
          alertDiv.role = 'alert';
          alertDiv.innerText = 'Giá gốc phải lớn hơn giá sale.';
          alertPlaceholder.append(alertDiv);
          event.preventDefault();
          event.stopPropagation();
      }
  });
</script>

@if (session()->has('success'))
<script>
  $(document).ready(function() {
      setTimeout(function() {
          $(".alert-success").fadeOut("slow");
      }, 5000); // Thay đổi bằng số miligiây bạn muốn thông báo hiển thị
  });
  </script>
@endif

@endsection


