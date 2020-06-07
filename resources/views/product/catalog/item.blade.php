<div class="col-lg-3 col-md-4 col-sm-6 my-2">
    <div class="card">
        @unless(is_null($product->thumbnail) || empty($product->thumbnail))
            <img src="{{ $product->thumbnail }}" class="card-img-top" alt="{{ $product->name }}" style="object-fit: cover;width: 100%;height: 150px">
        @endunless
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('product', compact('product')) }}" class="text-body font-weight-bold text-decoration-none">{{ $product->name }}</a>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $product->price_rupiah }}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Stok {{ $product->stock_availability }}</h6>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.product.edit', compact('product')) }}" class="btn btn-outline-primary">Ubah</a>
                @endif
            @endauth
        </div>
    </div>
</div>
