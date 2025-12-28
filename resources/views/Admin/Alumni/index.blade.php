@extends('Admin.Layouts.main')

@section('container')
    <!-- Page Heading -->
    {{-- <h1 class="h3 mb-2 text-gray-800">Tables</h1> --}}


    <!-- DataTales Example -->
    <div class="card mb-4 shadow">
        <div class="card-header py-3">
            <h6 class="font-weight-bold text-success m-0">Data Alumni</h6>
        </div>
        <div class="card-body">

            @session('success')
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endsession

            <div class="d-flex ">

                {{-- <a href="{{ url('alumni/create') }}" class="btn btn-primary mb-3" style="margin-right: 10px">Tambah</a> --}}

                @if (Auth::guard('admin_pimpinan')->user()->is_admin)
                    @if (count($alumnis) > 0)
                        <a href="{{ url('cluster') }}" class="btn btn-success mb-3">Cluster</a>
                    @endif
                @endif

            </div>

            <div class="table-responsive">
                @if (Auth::guard('admin_pimpinan')->user()->is_admin)
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
                                        <div class="d-flex g-2">

                                            {{-- MODAL UNTUK SHOW --}}
                                            <button type="button" class="btn btn-sm btn-info detail-button"
                                                style="margin-right: 10px" data-toggle="modal"
                                                data-target="#detailAlumniModal" data-nis="{{ $alumni->nis }}"
                                                data-nama="{{ $alumni->nama_lengkap }}"
                                                data-tgllahir="{{ date('d-m-Y', strtotime($alumni->tanggal_lahir)) }}"
                                                data-jk="{{ $alumni->jenis_kelamin == 'laki_laki' ? 'Laki-laki' : 'Perempuan' }}"
                                                data-email="{{ $alumni->email }}" data-telp="{{ $alumni->no_telepon }}"
                                                data-alamat="{{ $alumni->alamat }}"
                                                data-pekerjaan="{{ ucfirst(str_replace('_', ' ', $alumni->jenis_pekerjaan)) }}"
                                                data-n_pekerjaan="{{ $alumni->nama_pekerjaan ?? '-' }}"
                                                data-t_kerja="{{ $alumni->nama_tempat_bekerja ?? '-' }}"
                                                data-pendidikan="{{ $alumni->jenjang_pendidikan }}"
                                                data-lulus="{{ $alumni->tahun_lulus }}"
                                                data-domisili="{{ $alumni->domisili }}"
                                                data-keahlian="{{ ucfirst($alumni->jenis_keahlian) }}"
                                                data-gambar="{{ $alumni->gambar ? asset('File/' . $alumni->gambar) : 'https://ui-avatars.com/api/?name=' . urlencode($alumni->nama_lengkap) }}">
                                                <i class="bi bi-eye"></i>
                                            </button>

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
                @else
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
                                        <div class="d-flex g-2">

                                            {{-- MODAL UNTUK SHOW --}}
                                            <button type="button" class="btn btn-sm btn-info detail-button"
                                                style="margin-right: 10px" data-toggle="modal"
                                                data-target="#detailAlumniModal" data-nis="{{ $alumni->nis }}"
                                                data-nama="{{ $alumni->nama_lengkap }}"
                                                data-tgllahir="{{ date('d-m-Y', strtotime($alumni->tanggal_lahir)) }}"
                                                data-jk="{{ $alumni->jenis_kelamin == 'laki_laki' ? 'Laki-laki' : 'Perempuan' }}"
                                                data-email="{{ $alumni->email }}" data-telp="{{ $alumni->no_telepon }}"
                                                data-alamat="{{ $alumni->alamat }}"
                                                data-pekerjaan="{{ ucfirst(str_replace('_', ' ', $alumni->jenis_pekerjaan)) }}"
                                                data-n_pekerjaan="{{ $alumni->nama_pekerjaan ?? '-' }}"
                                                data-t_kerja="{{ $alumni->nama_tempat_bekerja ?? '-' }}"
                                                data-pendidikan="{{ $alumni->jenjang_pendidikan }}"
                                                data-lulus="{{ $alumni->tahun_lulus }}"
                                                data-domisili="{{ $alumni->domisili }}"
                                                data-keahlian="{{ ucfirst($alumni->jenis_keahlian) }}"
                                                data-gambar="{{ $alumni->gambar ? asset('File/' . $alumni->gambar) : 'https://ui-avatars.com/api/?name=' . urlencode($alumni->nama_lengkap) }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL UNTUK SHOW --}}
    <div class="modal fade" id="detailAlumniModal" tabindex="-1" role="dialog" aria-labelledby="detailAlumniModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="detailAlumniModalLabel">Detail Alumni: <span id="modal-nama-title"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <img id="modal-gambar" src="" class="img-fluid rounded shadow-sm border"
                                alt="Foto Alumni" style="max-height: 200px;">
                            <div class="mt-2">
                                <span id="modal-pendidikan-badge" class="badge badge-success px-3"></span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="150">NIS</th>
                                    <td>: <span id="modal-nis"></span></td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>: <span id="modal-nama"></span></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>: <span id="modal-tgllahir"></span></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>: <span id="modal-jk"></span></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: <span id="modal-email"></span></td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>: <span id="modal-telp"></span></td>
                                </tr>
                                <tr>
                                    <th>Domisili</th>
                                    <td>: <span id="modal-domisili"></span></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: <span id="modal-alamat"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-success">Pekerjaan</h6>
                            <p class="mb-1"><strong>Jenjang Pendidikan:</strong> <span id="modal-pendidikan"></span>
                            </p>
                            <p class="mb-1"><strong>Status:</strong> <span id="modal-pekerjaan"></span></p>
                            <p class="mb-1"><strong>Jabatan:</strong> <span id="modal-n_pekerjaan"></span></p>
                            <p class="mb-1"><strong>Perusahaan:</strong> <span id="modal-t_kerja"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-success">Pendidikan & Keahlian</h6>
                            <p class="mb-1"><strong>Tahun Lulus:</strong> <span id="modal-lulus"></span></p>
                            <p class="mb-1"><strong>Keahlian:</strong> <span id="modal-keahlian"></span></p>
                        </div>
                    </div>
                    {{-- <div class="mt-3">
                        <h6 class="font-weight-bold text-primary">Alamat</h6>
                        <p id="modal-alamat" class="p-2 border rounded bg-light"></p>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.detail-button').forEach(button => {
                button.addEventListener('click', function() {
                    // Mapping ID elemen modal
                    const fields = [
                        'nis', 'nama', 'tgllahir', 'jk', 'email', 'telp',
                        'alamat', 'pekerjaan', 'n_pekerjaan', 't_kerja',
                        'pendidikan', 'lulus', 'domisili', 'keahlian'
                    ];

                    // Isi teks biasa
                    fields.forEach(field => {
                        const dataValue = this.getAttribute('data-' + field);
                        const element = document.getElementById('modal-' + field);
                        if (element) element.textContent = dataValue || '-';
                    });

                    // Khusus untuk elemen yang bukan textContent
                    document.getElementById('modal-nama-title').textContent = this.getAttribute(
                        'data-nama');
                    document.getElementById('modal-pendidikan-badge').textContent = this
                        .getAttribute('data-pendidikan');

                    // Isi Gambar
                    const gambarSrc = this.getAttribute('data-gambar');
                    document.getElementById('modal-gambar').src = gambarSrc;
                });
            });
        });
    </script>

@endsection
