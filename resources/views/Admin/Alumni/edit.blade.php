    @extends('Admin.Layouts.main')

    @section('container')
        <div class="row">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Data Alumni</h5>
                </div>

                <div class="card-body">

                    @session('error')
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endsession

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ url('/alumni/' . $alumni->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <!-- NIS -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">NIS Alumni</label>
                                <input type="text" class="form-control" value="{{ $alumni->nis }}" name="nis">
                            </div>

                            <!-- Nama -->
                            <div class="col-md-8 mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    value="{{ old('nama_lengkap', $alumni->nama_lengkap) }}">
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir', $alumni->tanggal_lahir) }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="custom-select @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    <option value="laki_laki"
                                        {{ old('jenis_kelamin', $alumni->jenis_kelamin) == 'laki_laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="perempuan"
                                        {{ old('jenis_kelamin', $alumni->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">No Telepon</label>
                                <input type="text" name="no_telepon"
                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                    value="{{ old('no_telepon', $alumni->no_telepon) }}">
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $alumni->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat', $alumni->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-3">

                            <!-- Jenis Pekerjaan -->
                            <div class="col-md-4">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <select name="jenis_pekerjaan"
                                    class="custom-select @error('jenis_pekerjaan') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach (['pns', 'wiraswasta', 'mahasiswa', 'lain_lain'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('jenis_pekerjaan', $alumni->jenis_pekerjaan) == $item ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $item)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenjang Pendidikan -->
                            <div class="col-md-4">
                                <label class="form-label">Jenjang Pendidikan</label>
                                <select name="jenjang_pendidikan"
                                    class="custom-select @error('jenjang_pendidikan') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach (['SMA', 'D3', 'S1', 'S2', 'S3'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('jenjang_pendidikan', $alumni->jenjang_pendidikan) == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenjang_pendidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tahun Lulus -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="number" name="tahun_lulus"
                                    class="form-control @error('tahun_lulus') is-invalid @enderror" min="2021"
                                    max="{{ date('Y') }}" value="{{ old('tahun_lulus', $alumni->tahun_lulus) }}">
                                @error('tahun_lulus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Domisili -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Domisili</label>
                                <select name="domisili" class="custom-select @error('domisili') is-invalid @enderror">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{ $item }}"
                                            {{ old('domisili', $alumni->domisili) == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('domisili')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Keahlian -->
                            <div class="col-md-4">
                                <label class="form-label">Jenis Keahlian</label>
                                <select name="jenis_keahlian"
                                    class="custom-select @error('jenis_keahlian') is-invalid @enderror">
                                    <option value="">-- Pilih --</option>
                                    @foreach (['teknologi', 'pendidikan', 'kesehatan', 'pertanian', 'lain_lain'] as $item)
                                        <option value="{{ $item }}"
                                            {{ old('jenis_keahlian', $alumni->jenis_keahlian) == $item ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $item)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_keahlian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ url('/alumni') }}" class="btn btn-secondary me-2">Kembali</a>
                            <button type="submit" class="btn btn-success">Update Data Alumni</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection
