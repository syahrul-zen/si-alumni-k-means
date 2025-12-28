@extends('Admin.Layouts.main')

@section('container')
    @if (Auth::guard('admin_pimpinan')->user()->is_admin)
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="d-flex">
                <a href="{{ url('set-admin') }}" class="btn btn-success" style="margin-right: 10px">Edit Admin</a>
                <a href="{{ url('set-pimpinan') }}" class="btn btn-success">Edit Pimpinan</a>
            </div>
        </div>
    @endif

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
