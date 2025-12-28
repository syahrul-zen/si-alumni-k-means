@extends('Admin.Layouts.main')

@section('container')
    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-12 mb-4">
            <!-- Approach -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success text-center">{{ $berita->judul }}</h6>
                </div>
                <div class="card-body">

                    <!-- Gambar Berita -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('File/' . $berita->gambar) }}" class="img-fluid rounded" alt="{{ $berita->judul }}">
                    </div>

                    <!-- Tanggal Publikasi -->
                    <p class="text-muted mb-3">
                        <i class="far fa-calendar-alt"></i>
                        <small>Dipublikasikan pada: {{ date('d F Y', strtotime($berita->tanggal)) }}</small>
                    </p>

                    <!-- Deskripsi Berita -->
                    <div class="content-description">
                        {!! $berita->deskripsi !!}
                    </div>

                </div>

                <!-- Card Footer untuk Tombol Aksi -->
                <div class="card-footer text-muted">
                    <a href="{{ url('dashboard-alumni') }}"
                        class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar Berita
                    </a>

                </div>
            </div>
        </div>

    </div>
@endsection
