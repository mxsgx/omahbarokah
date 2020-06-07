@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Produk</div>

                    <div class="card-body">
                        @if(session('success'))
                            <x-alert type="success" :dismissible="true">{{ session('success') }}</x-alert>
                        @endif
                        <div class="mb-3">
                            <x-link-button text="Tambah Produk" :href="route('admin.product.create')"/>
                        </div>
                        <div class="table-responsive p-2">
                            <table id="datatables" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col"><span class="sr-only">Gambar</span></th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col"><span class="sr-only">Aksi</span></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col"><span class="sr-only">Gambar</span></th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col"><span class="sr-only">Aksi</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('footer.scripts')
        <script type="text/javascript">
            jQuery('#datatables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route(Route::currentRouteName()) }}",
                },
                columns: [
                    {
                        data: 'id'
                    },
                    {
                        data: 'thumbnail',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'stock',
                    },
                    {
                        data: 'price_rupiah',
                        name: 'price',
                    },
                    {
                        data: 'action',
                        searchable: false,
                        orderable: false,
                    },
                ],
            });
        </script>
    @endpush
@endsection
