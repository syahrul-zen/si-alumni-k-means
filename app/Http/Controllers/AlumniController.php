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

        return view('Admin.Alumni.index');
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
        /* =======================
         * 1. VALIDASI DATA
         * ======================= */
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:alumnis,nis',
            'nama_lengkap' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki_laki, perempuan',
            'alamat' => 'required|max:240',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email',

            'jenis_pekerjaan' => 'required|in:wirausaha,profesional,mahasiswa',
            'jenjang_pendidikan' => 'required|in:SMA,D3,S1,S2,S3',
            'tahun_lulus' => 'required|integer|min:2021|max:'.date('Y'),
            'domisili' => 'required|string',
            'jenis_keahlian' => 'required|in:kewirausahaan,teknologi,kreatif,administrasi,akademik,dll',
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
    public function edit(Alumni $alumni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumni $alumni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumni $alumni)
    {
        //
    }

    private function mapJenisPekerjaan($value)
    {
        return match ($value) {
            'mahasiswa' => 1,
            'profesional' => 2,
            'wirausaha' => 3,
        };
    }

    private function mapJenjangPendidikan($value)
    {
        return match ($value) {
            'SMA' => 1,
            'D3' => 2,
            'S1' => 3,
            'S2' => 4,
            'S3' => 5,
        };
    }

    private function mapJenisKeahlian($value)
    {
        return match ($value) {
            'administrasi' => 1,
            'kreatif' => 2,
            'teknologi' => 3,
            'akademik' => 4,
            'kewirausahaan' => 5,
            'dll' => 3, // netral
        };
    }

    private function mapDomisili($value)
    {
        // Alumni lokal (Jambi)
        return strtolower($value) === 'jambi' ? 1 : 0;
    }

    private function normalizeTahunLulus($tahun)
    {
        $min = 2021;
        $max = date('Y');

        return ($tahun - $min) / ($max - $min);
    }
}
