@extends('Admin.Layouts.main')

@section('container')
    <!-- DataTables Berita -->
    <div class="card mb-4 shadow">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-success m-0">Data Berita</h6>
        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ url('berita/create') }}" class="btn btn-success mb-3">
                Tambah Berita
            </a>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($beritas as $berita)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $berita->judul }}</td>
                                <td>{{ date('d-m-Y', strtotime($berita->tanggal)) }}</td>

                                <td class="text-center">
                                    @if ($berita->gambar)
                                        <img src="{{ asset('File/' . $berita->gambar) }}" alt="Gambar Berita"
                                            width="80">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>

                                <td>
                                    {!! Str::limit($berita->deskripsi, 100) !!}
                                </td>

                                <td>
                                    <div class="d-flex">
                                        <a href="{{ url("berita/$berita->id/edit") }}" class="btn btn-warning btn-sm mr-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ url("berita/$berita->id") }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
