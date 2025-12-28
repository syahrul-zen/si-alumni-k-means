@extends('Admin.Layouts.main')

@section('container')

    <div class="card shadow-sm">

        <div class="card-header bg-success text-white">
            <h5>Edit Data Alumni</h5>
        </div>

        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @session('error')
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endsession

            @session('success')
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endsession

            <form action="{{ url('/update-alumni/' . $alumni->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <!-- NIS -->
                    <div class="col-md-4 mb-2">
                        <label for="nis" class="form-label">NIS Alumni</label>
                        <input type="text" name="nis" id="nis" class="form-control"
                            value="{{ @old('nis', $alumni->nis) }}" required>
                    </div>

                    <!-- Nama -->
                    <div class="col-md-8 mb-2">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ @old('nama_lengkap', $alumni->nama_lengkap) }}"
                            id="nama_lengkap" class="form-control" required>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="col-md-4 mb-2">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ @old('tanggal_lahir', $alumni->tanggal_lahir) }}" class="form-control" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-4 mb-2">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="laki_laki" @selected(@old('jenis_kelamin', $alumni->jenis_kelamin) == 'laki_laki')>Laki-laki</option>
                            <option value="perempuan" @selected(@old('jenis_kelamin', $alumni->jenis_kelamin) == 'perempuan')>Perempuan</option>
                        </select>
                    </div>

                    <!-- No Telepon -->
                    <div class="col-md-4 mb-2">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon"
                            value="{{ @old('no_telepon', $alumni->no_telepon) }}" class="form-control">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ @old('email', $alumni->email) }}" id="email"
                            class="form-control">
                    </div>

                    <!-- Alamat -->
                    <div class="col-md-6 mb-2">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2">{{ @old('alamat', $alumni->alamat) }}</textarea>
                    </div>

                    <div class="col-lg-6 mb-2">
                        <label for="password" class="form-label">Password (Kosongkan jika tidak ingin merubah)</label>
                        <input type="text" name="password" id="password" class="form-control">
                    </div>

                    <div class="col-lg-6 mb-2">
                        <label class="form-label">Gambar Berita</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*"
                            onchange="previewGambar()">

                        <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>

                        <!-- Preview -->
                        <div class="mt-3">
                            <img id="preview-image" src="{{ url('File/' . $alumni->gambar) }}" alt="Preview Gambar"
                                style="max-width:200px; border-radius:5px;">
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Jenis Pekerjaan -->
                    <div class="col-md-4">
                        <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="custom-select form-control" required>
                            <option>-- Pilih --</option>
                            <option value="pns" @selected(@old('jenis_pekerjaan', $alumni->jenis_pekerjaan) == 'pns')>PNS</option>
                            <option value="wiraswasta" @selected(@old('jenis_pekerjaan', $alumni->jenis_pekerjaan) == 'wiraswasta')>Wiraswasta</option>
                            <option value="mahasiswa" @selected(@old('jenis_pekerjaan', $alumni->jenis_pekerjaan) == 'mahasiswa')>Mahasiswa</option>
                            <option value="lain_lain" @selected(@old('jenis_pekerjaan', $alumni->jenis_pekerjaan) == 'lain_lain')>Lain-lain</option>
                        </select>
                    </div>

                    <!-- Jenjang Pendidikan -->
                    <div class="col-md-4">
                        <label for="jenjang_pendidikan" class="form-label">Jenjang Pendidikan</label>
                        <select name="jenjang_pendidikan" id="jenjang_pendidikan" class="custom-select form-control"
                            required>
                            <option>-- Pilih --</option>
                            <option value="SMA" @selected(@old('jenjang_pendidikan', $alumni->jenjang_pendidikan) == 'SMA')>SMA</option>
                            <option value="D3" @selected(@old('jenjang_pendidikan', $alumni->jenjang_pendidikan) == 'D3')>D3</option>
                            <option value="S1" @selected(@old('jenjang_pendidikan', $alumni->jenjang_pendidikan) == 'S1')>S1</option>
                            <option value="S2" @selected(@old('jenjang_pendidikan', $alumni->jenjang_pendidikan) == 'S2')>S2</option>
                            <option value="S3" @selected(@old('jenjang_pendidikan', $alumni->jenjang_pendidikan) == 'S3')>S3</option>
                        </select>
                    </div>

                    <!-- Tahun Lulus -->
                    <div class="col-md-4 mb-2">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control"
                            value="{{ @old('tahun_lulus', $alumni->tahun_lulus) }}" min="2021"
                            max="{{ date('Y') }}">
                    </div>

                    <!-- Domisili -->
                    <div class="col-md-6 mb-2">
                        <label for="domisili" class="form-label">Domisili</label>
                        <select name="domisili" id="domisili" class="custom-select form-control" required>
                            <option>-- Pilih Provinsi --</option>
                            @foreach ($provinsi as $item)
                                <option value="{{ $item }}" @selected(@old('domisili', $alumni->domisili) == $item)>
                                    {{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jenis Keahlian -->
                    <div class="col-md-6 mb-2">
                        <label for="jenis_keahlian" class="form-label">Jenis Keahlian</label>
                        <select name="jenis_keahlian" id="jenis_keahlian" class="custom-select form-control" required>
                            <option>-- Pilih --</option>
                            <option value="teknologi" @selected(@old('jenis_keahlian', $alumni->jenis_keahlian) == 'teknologi')>Teknologi</option>
                            <option value="pendidikan" @selected(@old('jenis_keahlian', $alumni->jenis_keahlian) == 'pendidikan')>Pendidikan</option>
                            <option value="kesehatan" @selected(@old('jenis_keahlian', $alumni->jenis_keahlian) == 'kesehatan')>Kesehatan</option>
                            <option value="pertanian" @selected(@old('jenis_keahlian', $alumni->jenis_keahlian) == 'pertanian')>Pertanian</option>
                            <option value="lain_lain" @selected(@old('jenis_keahlian', $alumni->jenis_keahlian) == 'lain_lain')>Lain-lain</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                        <input type="text" name="nama_pekerjaan" id="nama_pekerjaan"
                            value="{{ @old('nama_pekerjaan', $alumni->nama_pekerjaan) }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="nama_tempat_bekerja" class="form-label">Nama Tempat Bekerja</label>
                        <input type="text" value="{{ @old('nama_tempat_bekerja', $alumni->nama_tempat_bekerja) }}"
                            name="nama_tempat_bekerja" id="nama_tempat_bekerja" class="form-control">
                    </div>

                </div>

                <div class="mt-4 text-end">
                    {{-- <a href="{{ url('/login') }}" class="btn btn-primary">
                        <i class="fas fa-door-open mr-2"></i> Login
                    </a> --}}
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewGambar() {
            const input = document.getElementById('gambar');
            const preview = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


@endsection
