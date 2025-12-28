@extends('Admin.Layouts.main')

@section('container')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Selamat Datang {{ $alumni->nama_lengkap }}</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Alumni</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahAlumni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Alumni Lokal + Wirausaha</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahAlumniC1 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-secret fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alumni Profesional
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $jumlahAlumniC2 }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Alumni Mahasisa/Belum Bekerja</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahAlumniC3 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    Jumlah Alumni 5 Tahun Terakhir
                </div>

                <div class="card-body">
                    <canvas id="alumniChart" height="120"></canvas>
                </div>
            </div>

        </div>
    </div>


    <div class="row mt-4">

        <div class="col-12">
            <h1 class="h3 mb-3 text-gray-800">Berita Terkini Pondok Pesantren</h1>
        </div>

        @forelse ($news as $item)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <img src="{{ asset('File/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}"
                        style="height: 200px; object-fit: cover;"> {{-- Tambahkan ini --}}

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->judul }}</h5>

                        <p class="card-text text-muted small">
                            <i class="far fa-calendar"></i>
                            {{ date('d F Y', strtotime($item->tanggal)) }}
                        </p>

                        <a href="{{ url('show-berita/' . $item->id) }}" class="btn btn-success btn-sm mt-auto">
                            Baca Selengkapnya <i class="fas fa-arrow-right fa-sm ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>


        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Belum ada berita untuk ditampilkan saat ini.
                </div>
            </div>
        @endforelse



    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $news->links() }}
    </div>

    <script src="{{ asset('FE/js/chart.js') }}"></script>
    <script>
        const ctx = document.getElementById('alumniChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar', // bisa diganti 'line'
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: @json($values),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endsection
