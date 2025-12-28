<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman Pendaftaran Sistem Informasi Alumni Pondok Pesantren">
    <meta name="author" content="Tim IT Pesantren">

    <title>Register - Sistem Informasi Alumni</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('FE/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600&display=swap" rel="stylesheet">

    <!-- Custom styles for this template (Bootstrap & SB Admin) -->
    <link href="{{ asset('FE/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom CSS untuk Tema Hijau Islami -->
    <style>
        /* --- GAYA DASAR & LATAR BELAKANG --- */
        body {
            background: linear-gradient(135deg, #1e4620 0%, #2e7d32 100%);
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }

        /* --- GAYA KARTU REGISTER --- */
        .card-container {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .card-register {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
        }

        /* --- LOGO BULAT --- */
        .logo-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid #f8f9fc;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        /* --- TIPOGRAFI --- */
        .text-welcome {
            font-family: 'Lora', serif;
            color: #1b5e20;
            font-weight: 600;
        }

        /* --- FORM & INPUT --- */
        .form-control,
        .custom-select {
            border: 1px solid #a5d6a7;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        hr {
            border-top: 1px solid #a5d6a7;
        }

        /* --- TOMBOL --- */
        .btn-success {
            background-color: #2e7d32;
            border-color: #2e7d32;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s;
        }

        .btn-primary {
            /* background-color: #2e7d32;
            border-color: #2e7d32; */
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background-color: #1b5e20;
            border-color: #1b5e20;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* --- ALERT --- */
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>

</head>

<body>

    <div class="container card-container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card o-hidden shadow-lg my-5 card-register">
                    <!-- Header dengan Logo -->
                    <div class="card-header text-center py-4">
                        <img src="{{ asset('FE/img/logo_bulat.png') }}" alt="Logo Pesantren" class="logo-img">
                        <h1 class="h4 text-welcome mt-3 mb-1">Assalamu'alaikum</h1>
                        <p class="mb-0">Formulir Pendaftaran Alumni Baru</p>
                    </div>

                    <!-- Body dengan Form -->
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

                        <form action="{{ url('/register') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <!-- NIS -->
                                <div class="col-md-4 mb-2">
                                    <label for="nis" class="form-label">NIS Alumni</label>
                                    <input type="text" name="nis" id="nis" class="form-control"
                                        value="{{ @old('nis') }}" required>
                                </div>

                                <!-- Nama -->
                                <div class="col-md-8 mb-2">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" value="{{ @old('nama_lengkap') }}"
                                        id="nama_lengkap" class="form-control" required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-4 mb-2">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ @old('tanggal_lahir') }}" class="form-control" required>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-4 mb-2">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select form-control"
                                        required>
                                        <option value="">-- Pilih --</option>
                                        <option value="laki_laki" @selected(@old('jenis_kelamin') == 'laki_laki')>Laki-laki</option>
                                        <option value="perempuan" @selected(@old('jenis_kelamin') == 'perempuan')>Perempuan</option>
                                    </select>
                                </div>

                                <!-- No Telepon -->
                                <div class="col-md-4 mb-2">
                                    <label for="no_telepon" class="form-label">No Telepon</label>
                                    <input type="text" name="no_telepon" id="no_telepon"
                                        value="{{ @old('no_telepon') }}" class="form-control">
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ @old('email') }}" id="email"
                                        class="form-control">
                                </div>

                                <!-- Alamat -->
                                <div class="col-md-6 mb-2">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="2">{{ @old('alamat') }}</textarea>
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" name="password" id="password" class="form-control">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label class="form-label">Gambar Berita</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control"
                                        accept="image/*" onchange="previewGambar()">

                                    <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>

                                    <!-- Preview -->
                                    <div class="mt-3">
                                        <img id="preview-image" src="#" alt="Preview Gambar"
                                            style="display:none; max-width:200px; border-radius:5px;">
                                    </div>
                                </div>

                                <hr class="my-3">

                                <!-- Jenis Pekerjaan -->
                                <div class="col-md-4">
                                    <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                                    <select name="jenis_pekerjaan" id="jenis_pekerjaan"
                                        class="custom-select form-control" required>
                                        <option>-- Pilih --</option>
                                        <option value="pns" @selected(@old('jenis_pekerjaan') == 'pns')>PNS</option>
                                        <option value="wiraswasta" @selected(@old('jenis_pekerjaan') == 'wiraswasta')>Wiraswasta</option>
                                        <option value="mahasiswa" @selected(@old('jenis_pekerjaan') == 'mahasiswa')>Mahasiswa</option>
                                        <option value="lain_lain" @selected(@old('jenis_pekerjaan') == 'lain_lain')>Lain-lain</option>
                                    </select>
                                </div>

                                <!-- Jenjang Pendidikan -->
                                <div class="col-md-4">
                                    <label for="jenjang_pendidikan" class="form-label">Jenjang Pendidikan</label>
                                    <select name="jenjang_pendidikan" id="jenjang_pendidikan"
                                        class="custom-select form-control" required>
                                        <option>-- Pilih --</option>
                                        <option value="SMA" @selected(@old('jenjang_pendidikan') == 'SMA')>SMA</option>
                                        <option value="D3" @selected(@old('jenjang_pendidikan') == 'D3')>D3</option>
                                        <option value="S1" @selected(@old('jenjang_pendidikan') == 'S1')>S1</option>
                                        <option value="S2" @selected(@old('jenjang_pendidikan') == 'S2')>S2</option>
                                        <option value="S3" @selected(@old('jenjang_pendidikan') == 'S3')>S3</option>
                                    </select>
                                </div>

                                <!-- Tahun Lulus -->
                                <div class="col-md-4 mb-2">
                                    <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control"
                                        value="{{ @old('tahun_lulus') }}" min="2021" max="{{ date('Y') }}">
                                </div>

                                <!-- Domisili -->
                                <div class="col-md-6 mb-2">
                                    <label for="domisili" class="form-label">Domisili</label>
                                    <select name="domisili" id="domisili" class="custom-select form-control"
                                        required>
                                        <option>-- Pilih Provinsi --</option>
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item }}" @selected(@old('domisili') == $item)>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Jenis Keahlian -->
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_keahlian" class="form-label">Jenis Keahlian</label>
                                    <select name="jenis_keahlian" id="jenis_keahlian"
                                        class="custom-select form-control" required>
                                        <option>-- Pilih --</option>
                                        <option value="teknologi" @selected(@old('jenis_keahlian') == 'teknologi')>Teknologi</option>
                                        <option value="pendidikan" @selected(@old('jenis_keahlian') == 'pendidikan')>Pendidikan</option>
                                        <option value="kesehatan" @selected(@old('jenis_keahlian') == 'kesehatan')>Kesehatan</option>
                                        <option value="pertanian" @selected(@old('jenis_keahlian') == 'pertanian')>Pertanian</option>
                                        <option value="lain_lain" @selected(@old('jenis_keahlian') == 'lain_lain')>Lain-lain</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_pekerjaan" class="form-label">Nama Pekerjaan</label>
                                    <input type="text" name="nama_pekerjaan" id="nama_pekerjaan"
                                        value="{{ @old('nama_pekerjaan') }}" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_tempat_bekerja" class="form-label">Nama Tempat Bekerja</label>
                                    <input type="text" value="{{ @old('nama_tempat_bekerja') }}"
                                        name="nama_tempat_bekerja" id="nama_tempat_bekerja" class="form-control">
                                </div>

                            </div>

                            <div class="mt-4 text-end">
                                <a href="{{ url('/login') }}" class="btn btn-primary">
                                    <i class="fas fa-door-open mr-2"></i> Login
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-2"></i> Register Alumni
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

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


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('FE/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('FE/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('FE/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('FE/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
