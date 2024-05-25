<div class="category-content">
    @foreach ($products as $key => $product)
        <div class="category-content-item">
            <a href="/san-pham/{{ $product->id }}-{{ \Str::slug($product->name, '-') }}.html"><img class="anhsp"
                    src="{{ $product->thumb }}" alt="">
                <h1>{{ $product->name }}</h1>
                <div class="price-product">
                    @if ($product->price_sale !== NULL)
                        <ins><span>{!! \App\Helpers\Helper::price($product->price_sale) !!}<sup>đ</sup></span></ins>
                        <del><span>{!! \App\Helpers\Helper::price($product->price) !!}<sup>đ</sup></span></del>
                    @elseif($product->price_sale == NULL && $product->price == NULL)
                    <span>{!! \App\Helpers\Helper::price($product->price) !!}</span>
                    @else
                        <span>{!! \App\Helpers\Helper::price($product->price) !!}<sup>đ</sup></span>
                    @endif
                </div>
            </a>
        </div>
    @endforeach
</div>
