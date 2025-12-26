<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\NumberDataAlumni;
use Exception;
use Illuminate\Http\Request; // Pastikan import ini ada di bagian atas file
use Illuminate\Support\Facades\DB;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('Admin.Alumni.index', [
            'alumnis' => Alumni::orderBy('tahun_lulus', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
            'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Kepulauan Bangka Belitung', 'Lampung',
            'DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara',
            'Maluku', 'Maluku Utara',
            'Papua Barat', 'Papua', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan', 'Papua Barat Daya',
        ];

        return view('Admin.Alumni.create', [
            'provinsi' => $provinsi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:alumnis,nis',
            'nama_lengkap' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki_laki, perempuan',
            'alamat' => 'required|max:240',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email',

            'jenis_pekerjaan' => 'required|in:pns,wiraswasta,mahasiswa,lain_lain',
            'jenjang_pendidikan' => 'required|in:SMA,D3,S1,S2,S3',
            'tahun_lulus' => 'required|integer|min:2021|max:' . date('Y'),
            'domisili' => 'required|string',
            'jenis_keahlian' => 'required|in:teknologi,pendidikan,kesehatan,pertanian,lain_lain',
        ]);


        DB::beginTransaction();

        try {
            /* =======================
             * 2. SIMPAN DATA ALUMNI
             * ======================= */
            $alumni = Alumni::create($validated);

            /* =======================
             * 3. KONVERSI KE NUMERIC
             * ======================= */
            $numericData = [
                'nis_alumni' => $alumni->nis,
                'value_jenis_pekerjaan' => $this->mapJenisPekerjaan($validated['jenis_pekerjaan']),
                'value_jenjang_pendidikan' => $this->mapJenjangPendidikan($validated['jenjang_pendidikan']),
                'value_tahun_lulus' => $this->normalizeTahunLulus($validated['tahun_lulus']),
                'value_domisili' => $this->mapDomisili($validated['domisili']),
                'value_jenis_keahlian' => $this->mapJenisKeahlian($validated['jenis_keahlian']),
            ];

            NumberDataAlumni::create($numericData);

            // Jika semua proses di atas berhasil, simpan permanen ke database
            DB::commit();

            return redirect()->back()->with('success', 'Data alumni berhasil disimpan!');

        } catch (Exception $e) {
            // Jika ada error sekecil apapun, batalkan semua perubahan di database
            DB::rollBack();

            // Log error atau kembalikan pesan error ke user
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }

        // return redirect()->back()->with('success', 'Data alumni berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Alumni $alumni)
    {

        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumni $alumnus)
    {

        $provinsi = [
            'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau',
            'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Kepulauan Bangka Belitung', 'Lampung',
            'DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur',
            'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara',
            'Sulawesi Utara', 'Sulawesi Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara',
            'Maluku', 'Maluku Utara',
            'Papua Barat', 'Papua', 'Papua Tengah', 'Papua Pegunungan', 'Papua Selatan', 'Papua Barat Daya',
        ];

        return view('Admin.Alumni.edit', [
            'alumni' => $alumnus,
            'provinsi' => $provinsi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumni $alumnus)
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki_laki, perempuan',
            'alamat' => 'required|max:240',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email',

            'jenis_pekerjaan' => 'required|in:pns,wiraswasta,mahasiswa,lain_lain',
            'jenjang_pendidikan' => 'required|in:SMA,D3,S1,S2,S3',
            'tahun_lulus' => 'required|integer|min:2021|max:' . date('Y'),
            'domisili' => 'required|string',
            'jenis_keahlian' => 'required|in:teknologi,pendidikan,kesehatan,pertanian,lain_lain',
        ];


        if ($request->nis != $alumnus->nis) {
            $rules['nis'] = 'required|string|max:20|unique:alumnis,nis';
        }

        $validated = $request->validate($rules);

        

        DB::beginTransaction();

        try {
            /* =======================
             * 2. SIMPAN DATA ALUMNI
             * ======================= */
            // $alumni = Alumni::create($validated);
            $alumnus->update($validated);

            /* =======================
             * 3. KONVERSI KE NUMERIC
             * ======================= */
            $numericData = [
                // 'nis_alumni' => $alumni->nis,
                'value_jenis_pekerjaan' => $this->mapJenisPekerjaan($validated['jenis_pekerjaan']),
                'value_jenjang_pendidikan' => $this->mapJenjangPendidikan($validated['jenjang_pendidikan']),
                'value_tahun_lulus' => $this->normalizeTahunLulus($validated['tahun_lulus']),
                'value_domisili' => $this->mapDomisili($validated['domisili']),
                'value_jenis_keahlian' => $this->mapJenisKeahlian($validated['jenis_keahlian']),
            ];

            NumberDataAlumni::where('nis_alumni', $alumnus->nis)->update($numericData);

            // NumberDataAlumni::create($numericData);

            // Jika semua proses di atas berhasil, simpan permanen ke database
            DB::commit();

            return redirect('alumni')->with('success', 'Data alumni berhasil disimpan!');

        } catch (Exception $e) {
            // Jika ada error sekecil apapun, batalkan semua perubahan di database
            DB::rollBack();

            // Log error atau kembalikan pesan error ke user
            return redirect()->back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumni $alumnus)
    {

        $getName = $alumnus->nama_lengkap;

        $alumnus->delete();

        return back()->with('success', 'Berhasil menghapus data alumni ' .  $getName);
    }

    public function clustering() {
            $dataAlumni = NumberDataAlumni::all()->toArray();

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
                [3,1,0.5,0.6,4],  // C1: Alumni lokal & berwirausaha
                [2,3,0.4,1,3],    // C2: Alumni profesional
                [1,2,0.3,0.5,2]   // C3: Alumni mahasiswa / lulusan baru
            ];

            $clusters = [];
            for ($i = 0; $i < $maxIterations; $i++) {
                $clusters = array_fill(0, $k, []);

                foreach ($dataPoints as $index => $point) {
                    $distances = array_map(fn($c) => $this->euclideanDistance($point, $c), $centroids);
                    $clusterIndex = array_search(min($distances), $distances);
                    $clusters[$clusterIndex][] = $index;
                }

                $newCentroids = [];
                foreach ($clusters as $cluster) {
                    $clusterPoints = array_map(fn($idx) => $dataPoints[$idx], $cluster);
                    $newCentroids[] = $this->calculateMean($clusterPoints);
                }

                if ($newCentroids === $centroids) break;
                $centroids = $newCentroids;
            }

            // Label cluster tetap
            $clusterLabels = [
                'Alumni lokal & berwirausaha',
                'Alumni profesional',
                'Alumni mahasiswa / lulusan baru'
            ];

            $clusterCounts = array_map(fn($c) => count($c), $clusters);
            $total = array_sum($clusterCounts);

            // Persentase tiap cluster
            $clusterPercent = array_map(fn($c) => round($c/$total*100,1), $clusterCounts);

            return $centroids;

            // Kirim data untuk chart
            return view('Admin.Alumni.chart', compact('clusterLabels','clusterCounts','clusterPercent'));
        }
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

        // ================================== KODINGAN LAMA ============================================================

        // private function euclideanDistance($a, $b)
        // {
        //     $sum = 0;
        //     foreach ($a as $i => $val) {
        //         $sum += pow($val - $b[$i], 2);
        //     }
        //     return sqrt($sum);
        // }

        // private function calculateMean($points)
        // {
        //     $count = count($points);
        //     $dim = count($points[0]);
        //     $mean = array_fill(0, $dim, 0);

        //     foreach ($points as $p) {
        //         foreach ($p as $i => $val) {
        //             $mean[$i] += $val;
        //         }
        //     }

        //     foreach ($mean as $i => $val) {
        //         $mean[$i] /= $count;
        //     }

        //     return $mean;
        // }


        // ====================================== KODINGAN LAMA ============================================================

        //     private function euclideanDistance($a, $b)
        //     {
        //         $sum = 0;
        //         foreach ($a as $i => $val) {
        //             $sum += pow($val - $b[$i], 2);
        //         }
        //         return sqrt($sum);
        //     }


        // private function calculateMean($points)
        // {
        //     $count = count($points);
        //     $dim = count($points[0]);
        //     $mean = array_fill(0, $dim, 0);

        //     foreach ($points as $p) {
        //         foreach ($p as $i => $val) {
        //             $mean[$i] += $val;
        //         }
        //     }

        //     foreach ($mean as $i => $val) {
        //         $mean[$i] /= $count;
        //     }

        //     return $mean;
        // }

        // // Fungsi interpretasi otomatis cluster
        // private function interpretCluster($centroid)
        // {
        //     [$pekerjaan, $pendidikan, $tahun, $domisili, $keahlian] = $centroid;

        //     if ($pekerjaan >= 2.8 && $domisili >= 0.6) {
        //         return 'Alumni lokal & berwirausaha';
        //     }

        //     if ($pekerjaan >= 1.8 && $pekerjaan < 2.8 && $pendidikan >= 3) {
        //         return 'Alumni profesional';
        //     }

        //     if ($pekerjaan < 1.8 && $tahun <= 0.4) {
        //         return 'Alumni mahasiswa / lulusan baru';
        //     }

        //     return 'Cluster lainnya';
        // }

}


    // FUNGSI K-MEAN :


    // ================================================ KODINGAN LAMA ===================================================================

    // public function clustering() {
    //     $k = 3; // jumlah cluster
    //     $maxIterasi = 100;

    //     // 1. Ambil data numerik alumni
    //     $data = NumberDataAlumni::all()->map(function ($item) {
    //         return [
    //             'nis' => $item->nis_alumni,
    //             'x' => [
    //                 $item->value_jenis_pekerjaan,
    //                 $item->value_jenjang_pendidikan,
    //                 $item->value_tahun_lulus,
    //                 $item->value_domisili,
    //                 $item->value_jenis_keahlian,
    //             ]
    //         ];
    //     })->toArray();

    //     // 2. Inisialisasi centroid awal (ambil data pertama)
    //     $centroids = array_slice(array_column($data, 'x'), 0, $k);

    //     $clusters = [];
    //     $iterasi = 0;

    //     do {
    //         $clusters = array_fill(0, $k, []);

    //         // 3. Hitung jarak & tentukan cluster
    //         foreach ($data as $item) {
    //             $jarak = [];

    //             foreach ($centroids as $i => $centroid) {
    //                 $jarak[$i] = $this->euclideanDistance($item['x'], $centroid);
    //             }

    //             $clusterIndex = array_keys($jarak, min($jarak))[0];
    //             $clusters[$clusterIndex][] = $item;
    //         }

    //         // 4. Hitung centroid baru
    //         $centroidBaru = [];
    //         foreach ($clusters as $cluster) {
    //             $centroidBaru[] = $this->hitungCentroid($cluster);
    //         }

    //         // 5. Cek konvergensi
    //         $berhenti = $this->centroidSama($centroids, $centroidBaru);
    //         $centroids = $centroidBaru;
    //         $iterasi++;

    //     } while (!$berhenti && $iterasi < $maxIterasi);

    //     foreach ($centroids as $i => $c) {
    //         echo "C".($i+1)." : ".$this->labelCluster($c).PHP_EOL;
    //     }



    //     return view('admin.clustering.hasil', [
    //         'clusters' => $clusters,
    //         'centroids' => $centroids,
    //         'iterasi' => $iterasi
    //     ]);
    // }

    // // ======================================================================

    // private function mapJenisPekerjaan($value)
    // {
    //     return match ($value) {
    //         'mahasiswa' => 1,
    //         'pns' => 2,
    //         'wiraswasta' => 3,
    //         'lain_lain' => 4,
    //     };
    // }

    // private function mapJenjangPendidikan($value)
    // {
    //     return match ($value) {
    //         'SMA' => 1,
    //         'D3' => 2,
    //         'S1' => 3,
    //         'S2' => 4,
    //         'S3' => 5,
    //     };
    // }

    // function mapJenisKeahlian($keahlian)
    // {
    //     return match (strtolower($keahlian)) {
    //         'teknologi'   => 1,
    //         'pendidikan'  => 2,
    //         'kesehatan'   => 3,
    //         'pertanian'   => 4,
    //         default       => 5, // lain_lain        
    //     };
    // }



    // private function mapDomisili($value)
    // {
    //     // Alumni lokal (Jambi)
    //     return strtolower($value) === 'jambi' ? 1 : 0;
    // }

    // private function normalizeTahunLulus($tahun)
    // {
    //     $min = 2021;
    //     $max = date('Y');

    //     return ($tahun - $min) / ($max - $min);
    // }

    // // Fungsi Untuk K-Means : 
    // // ================== FUNGSI BANTU ==================

    // private function euclideanDistance(array $a, array $b)
    // {
    //     $total = 0;
    //     foreach ($a as $i => $val) {
    //         $total += pow($val - $b[$i], 2);
    //     }
    //     return sqrt($total);
    // }

    // private function hitungCentroid(array $cluster)
    // {
    //     if (count($cluster) == 0) return [];

    //     $jumlahVariabel = count($cluster[0]['x']);
    //     $hasil = array_fill(0, $jumlahVariabel, 0);

    //     foreach ($cluster as $item) {
    //         foreach ($item['x'] as $i => $nilai) {
    //             $hasil[$i] += $nilai;
    //         }
    //     }

    //     foreach ($hasil as $i => $nilai) {
    //         $hasil[$i] = $nilai / count($cluster);
    //     }

    //     return $hasil;
    // }

    // private function centroidSama(array $lama, array $baru)
    // {
    //     foreach ($lama as $i => $centroid) {
    //         foreach ($centroid as $j => $nilai) {
    //             if (round($nilai, 6) != round($baru[$i][$j], 6)) {
    //                 return false;
    //             }
    //         }
    //     }
    //     return true;
    // }

    // // Label Cluster : 
    // private function labelCluster(array $centroid)
    // {
    //     [$pekerjaan, $pendidikan, $tahun, $domisili, $keahlian] = $centroid;

    //     // Alumni lokal & berwirausaha
    //     if ($pekerjaan >= 2.8 && $domisili >= 0.6) {
    //         return 'Alumni lokal dan berwirausaha';
    //     }

    //     // Alumni profesional
    //     if ($pekerjaan >= 1.8 && $pekerjaan < 2.8 && $pendidikan >= 3) {
    //         return 'Alumni profesional';
    //     }

    //     // Alumni mahasiswa / lulusan baru
    //     if ($pekerjaan < 1.8 && $tahun <= 0.4) {
    //         return 'Alumni mahasiswa / lulusan baru';
    //     }

    //     return 'Cluster lainnya';
    // }
