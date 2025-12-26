@extends('Admin.Layouts.main')

@section('container')
    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-2 text-gray-800">Tables</h1> --}}


    <!-- DataTales Example -->
    <div class="card mb-4 shadow">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-primary m-0">Data Alumni</h6>
        </div>
        <div class="card-body">

            @session('success')
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endsession

            <a href="{{ url('alumni/create') }}" class="btn btn-primary mb-3">Tambah</a>
            <div class="table-responsive">
                <table class="table-bordered table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tgl Lahir</th>
                            <th>JK</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Email</th>
                            <th>Tahun Lulus</th>
                            <th>Domisili</th>
                            <th>Jenjang Pendidikan</th>
                            <th>Jenis Pekerjaan</th>
                            <th>Jenis Keahlian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($alumnis as $alumni)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $alumni->nis }}</td>
                                <td>{{ $alumni->nama_lengkap }}</td>
                                <td>{{ date('d-m-Y', strtotime($alumni->tanggal_lahir)) }}</td>
                                <td>{{ $alumni->jenis_kelamin }}</td>
                                <td>{{ $alumni->alamat }}</td>
                                <td>{{ $alumni->no_telepon }}</td>
                                <td>{{ $alumni->email }}</td>
                                <td>{{ $alumni->tahun_lulus }}</td>
                                <td>{{ $alumni->domisili }}</td>
                                <td>{{ $alumni->jenjang_pendidikan }}</td>
                                <td>{{ $alumni->jenis_pekerjaan }}</td>
                                <td>{{ $alumni->jenis_keahlian }}</td>
                                <td>
                                    {{-- <a href="{{ url("alumni") }}" class="btn btn-success btn-sm"><i
                                            class="bi bi-house"></i></a> --}}

                                    <div class="d-flex g-2">

                                        <a href="{{ url("alumni/$alumni->id/edit") }}"
                                            class="btn btn-warning btn-sm mr-2"><i class="bi bi-pencil-square"></i></a>

                                        <form action="{{ url("alumni/$alumni->id") }}" method="POST" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                                                    class="bi bi-trash"></i></button>
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
