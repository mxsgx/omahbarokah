@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="{{ route('admin.user.store') }}" enctype="multipart/form-data" class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">Detail Pengguna</div>
                    <div class="card-body">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="name" class="sr-only">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required placeholder="Nama Pengguna">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="sr-only">E-Mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required placeholder="Alamat E-Mail">
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="sr-only">Kata Sandi</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Kata Sandi">
                            @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="sr-only">Peran</label>
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="staff">Karyawan</option>
                                <option value="client" selected>Pelanggan</option>
                            </select>
                            @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
