@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @each('product.catalog.item', $products, 'product', 'product.catalog.empty')
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection
