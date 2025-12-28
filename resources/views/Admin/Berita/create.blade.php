@extends('Admin.Layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Form Tambah Berita</h5>
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

                    <form action="{{ url('/berita') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            <!-- Judul -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Judul Berita</label>
                                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}"
                                    required>
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}"
                                    required>
                            </div>

                            <!-- Gambar -->
                            <!-- Gambar -->
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Gambar Berita</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*"
                                    onchange="previewGambar()">

                                <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>

                                <!-- Preview -->
                                <div class="mt-3">
                                    <img id="preview-image" src="#" alt="Preview Gambar"
                                        style="display:none; max-width:200px; border-radius:5px;">
                                </div>
                            </div>


                            <!-- Deskripsi -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Deskripsi Berita</label>
                                <input id="x" type="hidden" name="deskripsi" value="{{ @old('deskripsi') }}">
                                <trix-editor input="x"></trix-editor>
                                @error('deskripsi')
                                    <div class="label">
                                        <span class="text-red">{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ url('/berita') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                Simpan Berita
                            </button>
                        </div>

                    </form>
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

@endsection
