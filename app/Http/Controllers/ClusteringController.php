<?php

namespace App\Http\Controllers;


use App\Models\AlumniCluster;
use App\Models\Centroid;
use App\Models\NumberDataAlumni;

use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    public function clustering() {

        if (!Auth::guard('admin_pimpinan')->user()->is_admin) {
            return redirect('/');
        }

        $dataAlumni = NumberDataAlumni::all()->toArray();

        // --- Siapkan data untuk K-Means ---
        $dataPoints = array_map(function($item) {
            return [
                $item['value_jenis_pekerjaan'],
                $item['value_jenjang_pendidikan'],
                $item['value_tahun_lulus'],
                $item['value_domisili'],
                $item['value_jenis_keahlian']
            ];
        }, $dataAlumni);

        $k = 3;
        $maxIterations = 100;

        // Centroid tetap untuk hasil stabil
        $centroids = [
            [3,1,0.5,0.6,4],  
            [2,3,0.4,1,3],    
            [1,2,0.3,0.5,2]   
        ];

        $clusters = [];
        for ($i = 0; $i < $maxIterations; $i++) {
            $clusters = array_fill(0, $k, []);

            foreach ($dataPoints as $index => $point) {
                $distances = array_map(fn($c) => $this->euclideanDistance($point, $c), $centroids);
                $clusterIndex = array_search(min($distances), $distances);
                $clusters[$clusterIndex][] = $index;
            }

            // $newCentroids = [];
            
            // foreach ($clusters as $cluster) {
            //     $clusterPoints = array_map(fn($idx) => $dataPoints[$idx], $cluster);

            //     $newCentroids[] = $this->calculateMean($clusterPoints);
            // }

            $newCentroids = [];
            foreach ($clusters as $i => $cluster) {
            if (count($cluster) === 0) {
                // Cluster kosong → gunakan centroid lama
                $newCentroids[] = $centroids[$i];
            } else {
                $clusterPoints = array_map(fn($idx) => $dataPoints[$idx], $cluster);
                $newCentroids[] = $this->calculateMean($clusterPoints);
            }
        }

            if ($newCentroids === $centroids) break;
            $centroids = $newCentroids;
        }

        $clusterLabels = [
            'Alumni lokal & berwirausaha',
            'Alumni profesional',
            'Alumni mahasiswa / lulusan baru'
        ];

        // --- Simpan centroid ke DB ---
        Centroid::truncate();
        foreach($centroids as $idx => $c){
            Centroid::create([
                'cluster_id' => $idx,
                'cluster_label' => $clusterLabels[$idx],
                'values' => json_encode($c)
            ]);
        }

        // --- Simpan alumni per cluster menggunakan nis_alumni ---
        AlumniCluster::truncate();
        foreach($clusters as $idx => $cluster){
            foreach($cluster as $alumniIdx){
                $alumni = NumberDataAlumni::find($dataAlumni[$alumniIdx]['id']);

                AlumniCluster::create([
                    'nis_alumni' => $alumni->nis_alumni,
                    'cluster_id' => $idx,
                    'cluster_label' => $clusterLabels[$idx]
                ]);
            }
        }

        // --- Persentase tiap cluster ---
        // $clusterCounts = array_map(fn($c) => count($c), $clusters);
        // $total = array_sum($clusterCounts);
        // $clusterPercent = array_map(fn($c) => round($c/$total*100,1), $clusterCounts);

        return back()->with('success', "Berhasil mengcluster alumni, silahkan buka halaman grafik");

        // --- Kirim data untuk chart ---
        // return view('Admin.Alumni.chart', compact('clusterLabels','clusterCounts','clusterPercent'));
    }

    // 
        private function euclideanDistance($a, $b)
        {
            $sum = 0;
            foreach ($a as $i => $val) {
                $sum += pow($val - $b[$i], 2);
            }
            return sqrt($sum);
        }

    private function calculateMean($points)
    {
        $count = count($points);
        $dim = count($points[0]);
        $mean = array_fill(0, $dim, 0);

        foreach ($points as $p) {
            foreach ($p as $i => $val) {
                $mean[$i] += $val;
            }
        }

        foreach ($mean as $i => $val) {
            $mean[$i] /= $count;
        }

        return $mean;
    }

    // ==================================================== SHOW CLUSTERING =========================================================
    public function chartFromDB()
    {
            // --- Ambil centroid ---
        $centroids = Centroid::all();

        $clusterLabels = $centroids->pluck('cluster_label')->toArray();

        // --- Hitung jumlah alumni per cluster ---
        $alumniCounts = [];
        $clusterPercent = [];
        $total = 0;

        foreach($centroids as $c){
            $count = AlumniCluster::where('cluster_id', $c->cluster_id)->count();
            $alumniCounts[$c->cluster_id] = $count;
            $total += $count;
        }

        foreach($centroids as $c){
            $count = $alumniCounts[$c->cluster_id];
            $clusterPercent[] = $total ? round($count/$total*100,1) : 0;
        }

        // --- Ambil data alumni per cluster ---
        $alumniData = AlumniCluster::join('alumnis', 'alumni_clusters.nis_alumni', '=', 'alumnis.nis')
            ->select('alumnis.nis', 'alumnis.nama_lengkap','alumnis.tahun_lulus', 'alumni_clusters.cluster_id', 'alumni_clusters.cluster_label')
            ->orderBy('alumni_clusters.cluster_id')
            ->get();

        return view('Admin.Alumni.chart', compact(
            'centroids',
            'clusterLabels',
            'clusterPercent',
            'alumniCounts',
            'alumniData'
        ));
    }

    public function generatePdf()
    {
            $centroids = Centroid::all();
            $alumniCounts = [];
            foreach($centroids as $c){
                $alumniCounts[$c->cluster_id] = AlumniCluster::where('cluster_id', $c->cluster_id)->count();
            }

            $alumniData = AlumniCluster::join('alumnis', 'alumni_clusters.nis_alumni', '=', 'alumnis.nis')
                ->select('alumnis.nis', 'alumnis.nama_lengkap', 'alumni_clusters.cluster_id', 'alumni_clusters.cluster_label')
                ->orderBy('alumni_clusters.cluster_id')
                ->get();

            $pdf = Pdf::loadView('Admin.Alumni.laporan_pdf', compact('centroids','alumniCounts','alumniData'));
            return $pdf->stream('laporan_alumni.pdf');
    }

    public function generatePdfWithChart(Request $request)
    {
        $chartImage = $request->input('chart_image'); // base64 image dari canvas

        $centroids = Centroid::all();
        $alumniCounts = [];
        foreach($centroids as $c){
            $alumniCounts[$c->cluster_id] = AlumniCluster::where('cluster_id', $c->cluster_id)->count();
        }

        $alumniData = AlumniCluster::join('alumnis', 'alumni_clusters.nis_alumni', '=', 'alumnis.nis')
            ->select('alumnis.nis', 'alumnis.nama_lengkap', 'alumnis.tahun_lulus',  'alumni_clusters.cluster_id', 'alumni_clusters.cluster_label')
            ->orderBy('alumni_clusters.cluster_id')
            ->get();


        $pdf = Pdf::loadView('Admin.Alumni.laporan', compact('centroids','alumniCounts','alumniData','chartImage'));
        return $pdf->stream('laporan_alumni_chart.pdf');
    }


}
