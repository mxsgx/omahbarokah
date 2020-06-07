@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pengguna</div>

                    <div class="card-body">
                        @if(session('success'))
                            <x-alert type="success" :dismissible="true">{{ session('success') }}</x-alert>
                        @endif
                        <div class="mb-3">
                            <x-link-button text="Tambah Pengguna" :href="route('admin.user.create')"/>
                        </div>
                        <div class="table-responsive p-2">
                            <table id="datatables" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Peran</th>
                                        <th scope="col"><span class="sr-only">Aksi</span></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Peran</th>
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
                        data: 'name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'role',
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
