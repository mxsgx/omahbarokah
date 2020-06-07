@extends('layouts.app')

@push('footer.scripts')
    <script type="text/javascript">
        window.addEventListener('load', function () {
            tinymce.init({
                selector: '#description',
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <form method="post" action="{{ route('admin.product.update', compact('product')) }}" enctype="multipart/form-data" class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">Detail Produk</div>

                    <div class="card-body">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name" class="sr-only">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required placeholder="Nama Produk" value="{{ $product->name }}">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" required value="{{ $product->stock }}">
                                @error('stock')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required value="{{ $product->price }}">
                                    @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="sr-only">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control">
                                {!! $product->description !!}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Aksi</div>

                    <div class="card-body">
                        <div class="form-group form-check">
                            <input type="checkbox" id="is-private" name="is_private" class="form-check-input" value="1" @if($product->is_private) checked @endif>
                            <label for="is-private" class="form-check-label @error('is_private') is-invalid @enderror">Sembunyikan Produk</label>
                            @error('is_private')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Gambar Produk</div>

                    <div class="card-body">
                        <div class="form-group">
                            @unless(is_null($product->thumbnail))
                                <img src="{{ $product->thumbnail }}" class="img-thumbnail mb-3" alt="{{ $product->name }}">
                            @endunless
                            <label for="thumbnail">Pilih Gambar</label>
                            <input type="file" name="_thumbnail" class="form-control-file @error('_thumbnail') is-invalid @enderror" id="thumbnail" accept="image/*">
                            @error('_thumbnail')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
