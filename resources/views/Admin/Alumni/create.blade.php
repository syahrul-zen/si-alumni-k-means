@extends("Admin.Layouts.main")

@section("container")
    <div class="row">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Data Alumni</h5>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @session("success")
                    <div class="alert alert-success">
                        {{ session("success") }}
                    </div>
                @endsession

                @session("error")
                    <div class="alert alert-danger">
                        {{ session("error") }}
                    </div>
                @endsession

                <form action="{{ url("/alumni") }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- NIS -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">NIS Alumni</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>

                        <!-- Nama -->
                        <div class="col-md-8 mb-2">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="custom-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="laki_laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>

                        <!-- No Telepon -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>

                        <hr class="my-3">

                        <!-- Jenis Pekerjaan -->
                        <div class="col-md-4">
                            <label class="form-label">Jenis Pekerjaan</label>
                            <select name="jenis_pekerjaan" class="custom-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="wirausaha">Wirausaha</option>
                                <option value="profesional">Profesional</option>
                                <option value="mahasiswa">Mahasiswa / Belum Bekerja</option>
                            </select>
                        </div>

                        <!-- Jenjang Pendidikan -->
                        <div class="col-md-4">
                            <label class="form-label">Jenjang Pendidikan</label>
                            <select name="jenjang_pendidikan" class="custom-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="SMA">SMA</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        <!-- Tahun Lulus -->
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control" min="2021"
                                max="{{ date("Y") }}">
                        </div>

                        <!-- Domisili -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Domisili</label>
                            <select name="domisili" class="custom-select" required>
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Keahlian -->
                        <div class="col-md-4">
                            <label class="form-label">Jenis Keahlian</label>
                            <select name="jenis_keahlian" class="custom-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="kewirausahaan">Kewirausahaan</option>
                                <option value="teknologi">Teknologi</option>
                                <option value="kreatif">Kreatif</option>
                                <option value="administrasi">Administrasi</option>
                                <option value="akademik">Akademik</option>
                                <option value="dll">Lainnya</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">
                            Simpan Data Alumni
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
