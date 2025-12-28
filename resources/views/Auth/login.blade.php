<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Halaman Login Sistem Informasi Alumni Pondok Pesantren">
    <meta name="author" content="Tim IT Pesantren">

    <title>Login - Sistem Informasi Alumni</title>

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
            /* min-height: 100vh; */
        }

        /* --- GAYA KARTU LOGIN --- */
        .card-container {
            /* padding-top: 5rem;
            padding-bottom: 5rem; */
        }

        .card-login {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* --- GAMBAR MASJID --- */
        .bg-login-image {
            background: url({{ asset('FE/img/logo_kotak.png') }}) center center;
            background-size: cover;
        }

        /* --- TIPOGRAFI --- */
        .text-welcome {
            font-family: 'Lora', serif;
            color: #1b5e20;
            font-weight: 600;
        }

        .card-body .h4 {
            font-weight: 600;
        }

        /* --- FORM & INPUT --- */
        .form-control-user {
            border: 1px solid #a5d6a7;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .form-control-user:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        /* --- TOMBOL --- */
        .btn-user {
            background-color: #2e7d32;
            border-color: #2e7d32;
            color: white;
            font-weight: 600;
            padding: 0.75rem 0;
            transition: all 0.3s;
        }

        .btn-user:hover {
            background-color: #1b5e20;
            border-color: #1b5e20;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* --- LINK --- */
        .small,
        .text-gray-900 {
            color: #2e7d32;
        }

        .small a:hover {
            color: #1b5e20;
            text-decoration: underline;
        }

        /* --- CUSTOM CHECKBOX --- */
        .custom-control-input:checked~.custom-control-label::before {
            background-color: #2e7d32;
            border-color: #2e7d32;
        }
    </style>

</head>

<body>

    <div class="container card-container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden shadow-lg my-5 card-login">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- Kolom Gambar -->
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>

                            <!-- Kolom Form Login -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-welcome mb-2">Assalamu'alaikum</h1>
                                        <p class="mb-4">Selamat datang di Portal Alumni Pesantren</p>
                                    </div>

                                    @session('success')
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endsession

                                    @session('loginFailed')
                                        <div class="alert alert-danger">
                                            {{ session('loginFailed') }}
                                        </div>
                                    @endsession



                                    <form class="user" action="{{ url('/login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Masukkan Email Anda...">

                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror


                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" id="exampleInputPassword"
                                                placeholder="Kata Sandi">

                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div> --}}
                                        <button type="submit" class="btn btn-user btn-block">
                                            <i class="fas fa-sign-in-alt fa-fw mr-2"></i> Masuk
                                        </button>
                                        <a href="{{ url('/register') }}" class="btn btn-user btn-block">
                                            <i class="fas fa-user-graduate fa-fw mr-2"></i> Register Alumni
                                        </a>
                                        <hr>
                                        <!-- Opsi login sosial media bisa dihilangkan jika tidak perlu -->
                                        <!--
                                        <div class="text-center">
                                            <a class="small" href="index.html">Login dengan Google</a>
                                        </div>
                                        -->
                                    </form>
                                    {{-- <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Lupa Kata Sandi?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Belum punya akun? Daftar di sini!</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('FE/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('FE/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('FE/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('FE/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
