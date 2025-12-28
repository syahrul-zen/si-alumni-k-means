<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ClusteringController;
use App\Models\Alumni;
use App\Models\AlumniCluster;
use Illuminate\Support\Facades\Route;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

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

    $tahunSekarang = Carbon::now()->year;
    $tahunAwal = $tahunSekarang - 4;

    // Ambil jumlah alumni per tahun
    $data = Alumni::selectRaw('tahun_lulus, COUNT(*) as total')
        ->whereBetween('tahun_lulus', [$tahunAwal, $tahunSekarang])
        ->groupBy('tahun_lulus')
        ->orderBy('tahun_lulus')
        ->pluck('total', 'tahun_lulus')
        ->toArray();

    // Pastikan 5 tahun tetap muncul walau datanya 0
    $labels = [];
    $values = [];

    for ($tahun = $tahunAwal; $tahun <= $tahunSekarang; $tahun++) {
        $labels[] = $tahun;
        $values[] = $data[$tahun] ?? 0;
    }

    return view('Admin.dashboard', [
        'jumlahAlumni' => Alumni::count(),
        'jumlahAlumniC1' => AlumniCluster::where('cluster_id', 0)->count(),
        'jumlahAlumniC2' => AlumniCluster::where('cluster_id', 1)->count(),
        'jumlahAlumniC3' => AlumniCluster::where('cluster_id', 2)->count(),
        'labels' => $labels, 
        'values' => $values
    ]);
})->middleware('admin_pimpinan');

Route::resource('alumni', AlumniController::class)->middleware('admin_pimpinan');
Route::resource('berita', BeritaController::class);

Route::post("/register", [AlumniController::class, 'store']);

Route::get('/cluster', [ClusteringController::class, 'clustering'])->middleware('admin_pimpinan');

Route::get('/grafik', [ClusteringController::class, 'chartFromDB'])->middleware('admin_pimpinan');

Route::post('/admin/alumni/laporan-pdf-chart', [ClusteringController::class, 'generatePdfWithChart'])->name('alumni.laporan-pdf-chart');

// Controller untuk Authentication : 
Route::get('/login', [AuthController::class, 'login']);
Route::post("/login", [AuthController::class, 'authentication']);
Route::get('/register', [AuthController::class ,'register']);
Route::post("/logout", [AuthController::class, 'logout']);

// Route untuk alumni : 
Route::get("/dashboard-alumni", [AlumniController::class, 'dashboardAlumni'])->middleware('alumni');
Route::get("/show-berita/{beritum}", [BeritaController::class, 'show'])->middleware('alumni');
Route::get("/alumni-edit", [AlumniController::class, 'edit'])->middleware('alumni');
Route::put('/update-alumni/{alumnus}', [AlumniController::class, 'update'])->middleware('alumni');


Route::get('/test1', function() {
    return Auth::guard("admin_pimpinan")->user();
});

Route::get('/test2', function() {
    return Auth::guard("alumni")->user();
});