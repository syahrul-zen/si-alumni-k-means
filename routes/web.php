<?php

use App\Http\Controllers\AlumniController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Admin.dashboard');
});

Route::get('/alumni', function() {
    return view('Admin.Alumni.index');
});

Route::resource('alumni', AlumniController::class);


Route::get('/test', function () {
   
    // Mapping keahlian ke kode numerik
    function mapKeahlian($keahlianText) {
        $keahlianText = strtolower($keahlianText);

        if (in_array($keahlianText, ['wirausaha', 'bisnis', 'entrepreneur'])) {
            return 1;
        } elseif (in_array($keahlianText, ['it', 'programming', 'software'])) {
            return 2;
        } elseif (in_array($keahlianText, ['administrasi', 'manajemen'])) {
            return 3;
        } elseif (in_array($keahlianText, ['akademik', 'penelitian', 'riset'])) {
            return 4;
        } else {
            return 5; // Lain-lain (contoh: membuat bangunan)
        }
    }

    $data = [
        [
            'pekerjaan'      => 1, // Wirausaha
            'pendidikan'     => 3, // S1
            'tahun'          => 2021,
            'domisili'       => 1, // Jambi
            'keahlian_text'  => 'membuat bangunan',
            'keahlian'       => mapKeahlian('membuat bangunan')
        ],
        [
            'pekerjaan'      => 2, // Profesional
            'pendidikan'     => 4, // S2
            'tahun'          => 2019,
            'domisili'       => 2, // Luar Jambi
            'keahlian_text'  => 'programming',
            'keahlian'       => mapKeahlian('programming')
        ],
        [
            'pekerjaan'      => 3, // Mahasiswa
            'pendidikan'     => 3, // S1
            'tahun'          => 2023,
            'domisili'       => 1,
            'keahlian_text'  => 'penelitian',
            'keahlian'       => mapKeahlian('penelitian')
        ]
    ];


    // Fungsi Jarak Eculidian
    function euclideanDistance($a, $b) {
    return sqrt(
        pow($a['pekerjaan']  - $b['pekerjaan'], 2) +
        pow($a['pendidikan'] - $b['pendidikan'], 2) +
        pow($a['tahun']      - $b['tahun'], 2) +
        pow($a['domisili']   - $b['domisili'], 2) +
        pow($a['keahlian']   - $b['keahlian'], 2)
        );
    }

    $centroids = [
        ['pekerjaan'=>1,'pendidikan'=>3,'tahun'=>2020,'domisili'=>1,'keahlian'=>1], // Wirausaha lokal
        ['pekerjaan'=>2,'pendidikan'=>4,'tahun'=>2019,'domisili'=>2,'keahlian'=>2], // Profesional
        ['pekerjaan'=>3,'pendidikan'=>3,'tahun'=>2023,'domisili'=>1,'keahlian'=>4], // Mahasiswa
    ];


    $k = 3;
    $maxIteration = 10;

    for ($iter = 0; $iter < $maxIteration; $iter++) {

        $clusters = array_fill(0, $k, []);

        // Assign data ke cluster terdekat
        foreach ($data as $row) {
            $distances = [];
            foreach ($centroids as $centroid) {
                $distances[] = euclideanDistance($row, $centroid);
            }
            $clusterIndex = array_search(min($distances), $distances);
            $clusters[$clusterIndex][] = $row;
        }

        // Update centroid
        foreach ($clusters as $i => $cluster) {
            if (count($cluster) == 0) continue;

            $sum = ['pekerjaan'=>0,'pendidikan'=>0,'tahun'=>0,'domisili'=>0,'keahlian'=>0];

            foreach ($cluster as $item) {
                foreach ($sum as $key => $val) {
                    $sum[$key] += $item[$key];
                }
            }

            foreach ($sum as $key => $val) {
                $centroids[$i][$key] = $val / count($cluster);
            }
        }
    }

    foreach ($clusters as $i => $cluster) {
        echo "<b>Cluster ".($i+1)."</b><br>";
        foreach ($cluster as $row) {
            echo "- Keahlian: {$row['keahlian_text']} (kode {$row['keahlian']})<br>";
        }
        echo "<hr>";
    }

});

Route::get("/test2", function() {
    $data = [
        [
            'pekerjaan'=>1, // Wirausaha
            'pendidikan'=>3, // S1
            'tahun'=>2021,
            'domisili'=>1, // Jambi
            'keahlian'=>5, // Lain-lain (membuat bangunan)
            'keahlian_text'=>'membuat bangunan'
        ],
        [
            'pekerjaan'=>2, // Profesional
            'pendidikan'=>4, // S2
            'tahun'=>2019,
            'domisili'=>2,
            'keahlian'=>2, // Programming
            'keahlian_text'=>'programming'
        ],
        [
            'pekerjaan'=>3, // Mahasiswa
            'pendidikan'=>3, // S1
            'tahun'=>2023,
            'domisili'=>1,
            'keahlian'=>4, // Penelitian
            'keahlian_text'=>'penelitian'
        ],
    ];

    function getMinMax($data, $key) {
        $values = array_column($data, $key);
        return [
            'min' => min($values),
            'max' => max($values)
        ];
    }
    

    $fields = ['pekerjaan','pendidikan','tahun','domisili','keahlian'];
    $minMax = [];

    // Cari min & max tiap variabel
    foreach ($fields as $field) {
        $minMax[$field] = getMinMax($data, $field);
    }

    // Data hasil normalisasi
    $normalizedData = [];

    foreach ($data as $row) {
        $normRow = [];
        foreach ($fields as $field) {
            $min = $minMax[$field]['min'];
            $max = $minMax[$field]['max'];

            $normRow[$field] = ($max - $min == 0)
                ? 0
                : ($row[$field] - $min) / ($max - $min);
        }
        $normalizedData[] = $normRow;
    }

    function euclideanDistance($a, $b) {
        return sqrt(
            pow($a['pekerjaan']  - $b['pekerjaan'], 2) +
            pow($a['pendidikan'] - $b['pendidikan'], 2) +
            pow($a['tahun']      - $b['tahun'], 2) +
            pow($a['domisili']   - $b['domisili'], 2) +
            pow($a['keahlian']   - $b['keahlian'], 2)
        );
    }

    $centroids = [
        $normalizedData[0], // Wirausaha lokal
        $normalizedData[1], // Profesional
        $normalizedData[2], // Mahasiswa
    ];

    $k = 3;
    $maxIteration = 10;

    for ($iter = 0; $iter < $maxIteration; $iter++) {

        $clusters = array_fill(0, $k, []);

        // Assign ke cluster terdekat
        foreach ($normalizedData as $index => $row) {
            $distances = [];
            foreach ($centroids as $centroid) {
                $distances[] = euclideanDistance($row, $centroid);
            }

            $clusterIndex = array_search(min($distances), $distances);

            // Simpan index data asli
            $clusters[$clusterIndex][] = $index;
        }

        // Update centroid
        foreach ($clusters as $i => $cluster) {
            if (count($cluster) == 0) continue;

            $sum = array_fill_keys($fields, 0);

            foreach ($cluster as $dataIndex) {
                foreach ($fields as $field) {
                    $sum[$field] += $normalizedData[$dataIndex][$field];
                }
            }

            foreach ($fields as $field) {
                $centroids[$i][$field] = $sum[$field] / count($cluster);
            }
        }
    }

    foreach ($clusters as $i => $cluster) {
        echo "<b>Cluster ".($i+1)."</b><br>";

        if (count($cluster) == 0) {
            echo "- (Kosong)<br>";
        }

        foreach ($cluster as $idx) {
            echo "- Keahlian: ".$data[$idx]['keahlian_text'].
                " (kode ".$data[$idx]['keahlian'].")<br>";
        }
        echo "<hr>";
    }

});

Route::get("/test3", function() {
    $alumni = [
        ['nama'=>'A', 'data'=>[3,1,2018,2,5]], // wirausaha, jambi, bangunan
        ['nama'=>'B', 'data'=>[3,1,2019,2,5]],
        ['nama'=>'C', 'data'=>[3,1,2020,2,1]],

        ['nama'=>'D', 'data'=>[2,2,2017,1,2]], // profesional
        ['nama'=>'E', 'data'=>[2,2,2016,1,2]],
        ['nama'=>'F', 'data'=>[2,1,2018,1,3]],

        ['nama'=>'G', 'data'=>[1,1,2023,2,4]], // mahasiswa
        ['nama'=>'H', 'data'=>[1,1,2024,1,4]],
        ['nama'=>'I', 'data'=>[1,1,2022,2,1]],
        ['nama'=>'J', 'data'=>[1,1,2023,1,5]],
    ];

    function normalize($data) {
        $cols = count($data[0]);
        $min = $max = array_fill(0,$cols,0);

        for ($i=0;$i<$cols;$i++) {
            $col = array_column($data,$i);
            $min[$i] = min($col);
            $max[$i] = max($col);
        }

        return array_map(function($row) use ($min,$max){
            return array_map(function($v,$i) use ($min,$max){
                return ($max[$i]-$min[$i]==0)?0:($v-$min[$i])/($max[$i]-$min[$i]);
            }, $row, array_keys($row));
        }, $data);
    }

    function distance($a,$b){
            return sqrt(array_sum(array_map(fn($x,$i)=>pow($x-$b[$i],2),$a,array_keys($a))));
        }

        $data = normalize(array_column($alumni,'data'));
        $k = 3;
        $centroids = array_slice($data,0,$k);

        for ($iter=0;$iter<10;$iter++) {
            $clusters = array_fill(0,$k,[]);

            foreach ($data as $i=>$row) {
                $d = array_map(fn($c)=>distance($row,$c),$centroids);
                $clusters[array_search(min($d),$d)][] = $i;
            }

            foreach ($clusters as $i=>$cluster) {
                if (!$cluster) continue;
                $centroids[$i] = array_map(
                    fn($j)=>array_sum(array_column(array_map(fn($x)=>$data[$x],$cluster),$j))/count($cluster),
                    array_keys($data[0])
                );
            }
        }

        foreach ($clusters as $i=>$cluster) {
            echo "Cluster ".($i+1)."<br>";
            foreach ($cluster as $idx) {
                echo "- {$alumni[$idx]['nama']} | Keahlian: {$alumni[$idx]['data'][4]}<br>";
            }
            echo "<hr>";
        }

}); 

Route::get("/test4", function() {
    $alumni = [
        ['nama'=>'A','data'=>[3,1,2018,2,5]],
        ['nama'=>'B','data'=>[3,1,2019,2,5]],
        ['nama'=>'C','data'=>[3,1,2020,2,1]],
        ['nama'=>'D','data'=>[2,2,2017,1,2]],
        ['nama'=>'E','data'=>[2,2,2016,1,2]],
        ['nama'=>'F','data'=>[2,1,2018,1,3]],
        ['nama'=>'G','data'=>[1,1,2023,2,4]],
        ['nama'=>'H','data'=>[1,1,2024,1,4]],
        ['nama'=>'I','data'=>[1,1,2022,2,1]],
        ['nama'=>'J','data'=>[1,1,2023,1,5]],
    ];

    function normalize($data){
        $cols = count($data[0]);
        for($i=0;$i<$cols;$i++){
            $col = array_column($data,$i);
            $min[$i]=min($col); 
            $max[$i]=max($col);
        }

        return array_map(function($row) use($min,$max){
            return array_map(function($v,$i) use($min,$max){
                return ($max[$i]-$min[$i]==0)?0:($v-$min[$i])/($max[$i]-$min[$i]);
            },$row,array_keys($row));
        },$data);
    }

    function distance($a,$b){
    $sum=0;
    foreach($a as $i=>$v){
        $sum+=pow($v-$b[$i],2);
    }
        return sqrt($sum);
    }


    function distanceWeighted($a,$b,$w){
        $sum=0;
        foreach($a as $i=>$v){
            $sum+=$w[$i]*pow($v-$b[$i],2);
        }
        return sqrt($sum);
    }

    function kmeans($data,$k,$weights=null){
        $centroids=array_slice($data,0,$k);

        for($iter=0;$iter<10;$iter++){
            $clusters=array_fill(0,$k,[]);

            foreach($data as $i=>$row){
                $dist=[];
                foreach($centroids as $c){
                    $dist[] = $weights 
                        ? distanceWeighted($row,$c,$weights)
                        : distance($row,$c);
                }
                $clusters[array_search(min($dist),$dist)][]=$i;
            }

            foreach($clusters as $i=>$cluster){
                if(!$cluster) continue;
                foreach($data[0] as $j=>$v){
                    $centroids[$i][$j]=array_sum(
                        array_column(array_map(fn($x)=>$data[$x],$cluster),$j)
                    )/count($cluster);
                }
            }
        }
        return $clusters;
    }

    $data = normalize(array_column($alumni,'data'));
    $k = 3;

    // TANPA BOBOT
    $clusters1 = kmeans($data,$k);

    // DENGAN BOBOT (keahlian = 2)
    $weights = [1,1,1,1,2];
    $clusters2 = kmeans($data,$k,$weights);

    function show($clusters,$alumni,$title){
        echo "<h3>$title</h3>";
        foreach($clusters as $i=>$cluster){
            echo "Cluster ".($i+1)."<br>";
            foreach($cluster as $idx){
                echo "- {$alumni[$idx]['nama']} | Keahlian: {$alumni[$idx]['data'][4]}<br>";
            }
            echo "<hr>";
        }
    }

    show($clusters1,$alumni,"TANPA BOBOT KEAHLIAN");
    show($clusters2,$alumni,"DENGAN BOBOT KEAHLIAN");


});