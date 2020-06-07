@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verifikasi Alamat E-Mail Anda</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">Tautan verifikasi telah dikirim di alamat email kamu.</div>
                        @endif

                        Sebelum diproses, mohon cek email apakah sudah menerima tautan verifikasi. Jika belum menerima email
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">klik disini untuk meminta tautan lagi</button>
                            .
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
