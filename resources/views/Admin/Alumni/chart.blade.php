@extends('Admin.Layouts.main')

@section('container')
    <div class="container">
        <h3 class="mb-4">Persentase Alumni per Cluster</h3>

        <div class="d-flex justify-content-center align-items-center" style="width: 400px; height: 400px; margin: 20px auto;">
            <div style="position: relative; width: 100%; height: 100%;">
                <canvas id="clusterPieChart"></canvas>
            </div>
        </div>

        <hr>

        <h4>Detail Centroid dan Jumlah Alumni</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Cluster ID</th>
                        <th>Cluster Label</th>
                        <th>Centroid (JSON)</th>
                        <th>Jumlah Alumni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($centroids as $c)
                        <tr>
                            <td>{{ $c->cluster_id }}</td>
                            <td>{{ $c->cluster_label }}</td>
                            <td><small><code>{{ $c->values }}</code></small></td>
                            <td>{{ $alumniCounts[$c->cluster_id] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <hr>

        <h4>Data Alumni per Cluster</h4>
        <div class="scroll-container"
            style="max-height: 400px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px; padding: 10px; background: #f9f9f9;">

            @if (count($alumniData))
                <a href="#" id="btnPdfWithChart" class="btn btn-success my-3">Cetak PDF dengan Chart</a>
            @endif

            <table class="table table-bordered table-hover bg-white mb-0" id="dataTable">
                <thead class="thead-dark" style="position: sticky; top: -11px; z-index: 1;">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Tahun Lulus</th>
                        <th>Cluster ID</th>
                        <th>Cluster Label</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumniData as $index => $alumni)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $alumni->nis }}</td>
                            <td>{{ $alumni->nama_lengkap }}</td>
                            <td>{{ $alumni->tahun_lulus }}</td>
                            <td><span class="badge badge-info">{{ $alumni->cluster_id }}</span></td>
                            <td>{{ $alumni->cluster_label }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('FE/js/chart.js') }}"></script>

    <script>
        const ctx = document.getElementById('clusterPieChart').getContext('2d');
        const clusterPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($clusterLabels) !!},
                datasets: [{
                    label: 'Persentase Alumni',
                    data: {!! json_encode($clusterPercent) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Menjaga agar chart tetap di dalam 400px
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label;
                                const percent = context.formattedValue;
                                const counts = {!! json_encode($alumniCounts) !!};
                                const jumlah = counts[Object.keys(counts)[context.dataIndex]];
                                return `${label}: ${percent}% (${jumlah} alumni)`;
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        document.getElementById('btnPdfWithChart').addEventListener('click', function() {
            const canvas = document.getElementById('clusterPieChart');
            const chartImage = canvas.toDataURL("image/png"); // convert canvas ke base64

            // buat form untuk POST ke backend
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('alumni.laporan-pdf-chart') }}";
            form.target = "_blank";

            // csrf token
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = "_token";
            csrf.value = "{{ csrf_token() }}";
            form.appendChild(csrf);

            // kirim image
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = "chart_image";
            input.value = chartImage;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        });
    </script>
@endsection
