@extends('Admin.Layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Edit Pimpinan</h5>
                </div>

                <div class="card-body">

                    {{-- Error Validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Error Session --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ url('/set-admin/2') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="is_admin" value="{{ $user->is_admin }}">

                        <div class="row g-3">

                            <!-- Judul -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
