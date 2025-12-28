f
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Alumni</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }

        h3,
        h4 {
            margin-bottom: 10px;
            text-align: center;
        }

        /* Center judul */
        img.chart {
            /* display: block; */
            margin: 0 auto 20px;
            width: 400px;
            height: 400px;
        }

        /* Chart lebih besar dan di-center */
        .highlight {
            background-color: #ffff99;
            font-weight: bold;
        }

        /* Highlight cluster terbesar */
    </style>
</head>

<body>
    <h3>Laporan Alumni per Cluster</h3>

    <h4>Chart Pie Persentase Alumni</h4>

    <div style="text-align: center; width: 100%;">
        <img src="{{ $chartImage }}" alt="Chart Pie" style="width: 400px; height: 400px;">
    </div>


    @php
        $totalAlumni = array_sum($alumniCounts);
        $maxClusterId = array_search(max($alumniCounts), $alumniCounts);
    @endphp

    <h4>Total Alumni: {{ $totalAlumni }}</h4>

    <h4>Ringkasan Jumlah & Persentase Alumni per Cluster</h4>
    <table>
        <thead>
            <tr>
                <th>Cluster Label</th>
                <th>Jumlah Alumni</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($centroids as $c)
                @php
                    $jumlah = $alumniCounts[$c->cluster_id] ?? 0;
                    $persen = $totalAlumni ? round(($jumlah / $totalAlumni) * 100, 1) : 0;
                    $highlight = $c->cluster_id == $maxClusterId ? 'highlight' : '';
                @endphp
                <tr class="{{ $highlight }}">
                    <td>{{ $c->cluster_label }}</td>
                    <td>{{ $jumlah }}</td>
                    <td>{{ $persen }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Data Alumni per Cluster</h4>
    <table>
        <thead>
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
                    <td>{{ $alumni->cluster_id + 1 }}</td>
                    <td>{{ $alumni->cluster_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
