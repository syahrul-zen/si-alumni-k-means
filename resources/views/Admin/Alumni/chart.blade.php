@extends('Admin.Layouts.main')

@section('container')
    <div class="container">
        <h3>Distribusi Alumni per Cluster</h3>

        <div class="row">
            <div class="col-md-6">
                <canvas id="barChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const clusterLabels = {!! json_encode($clusterLabels) !!};
        const clusterCounts = {!! json_encode($clusterCounts) !!};
        const clusterPercent = {!! json_encode($clusterPercent) !!};

        // ===== Bar Chart =====
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: clusterLabels,
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: clusterCounts,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                return `${clusterLabels[index]}: ${clusterCounts[index]} alumni (${clusterPercent[index]}%)`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // ===== Pie Chart =====
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: clusterLabels.map((label, i) => `${label} (${clusterPercent[i]}%)`),
                datasets: [{
                    data: clusterCounts,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const index = context.dataIndex;
                                return `${clusterLabels[index]}: ${clusterCounts[index]} alumni (${clusterPercent[index]}%)`;
                            }
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
