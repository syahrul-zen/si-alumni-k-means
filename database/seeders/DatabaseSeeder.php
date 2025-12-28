<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumni;
use App\Models\NumberDataAlumni;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::create([
            'email' => 'admin@gmail.com',
            'name' => 'Admin',
            'password' => bcrypt('password'),
            'is_admin' => 1
        ]);

        \App\Models\User::create([
            'email' => 'pimpinan@gmail.com',
            'name' => 'Pimpinan',
            'password' => bcrypt('password'),
            'is_admin' => 0
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $data = [
        //     ['A001','Alumni A','laki_laki','wiraswasta','SMA',2021,'Jambi','pertanian'],
        //     ['A002','Alumni B','perempuan','pns','S1',2021,'Jambi','kesehatan'],
        //     ['A003','Alumni C','laki_laki','mahasiswa','SMA',2022,'Riau','pendidikan'],
        //     ['A004','Alumni D','perempuan','lain_lain','D3',2022,'Sumbar','lain_lain'],
        //     ['A005','Alumni E','laki_laki','wiraswasta','SMA',2023,'Jambi','pertanian'],
        //     ['A006','Alumni F','perempuan','pns','S2',2023,'Jambi','kesehatan'],
        //     ['A007','Alumni G','laki_laki','mahasiswa','S1',2024,'Jambi','teknologi'],
        //     ['A008','Alumni H','perempuan','mahasiswa','SMA',2024,'Riau','pendidikan'],
        //     ['A009','Alumni I','laki_laki','wiraswasta','D3',2025,'Jambi','pertanian'],
        //     ['A010','Alumni J','perempuan','pns','S1',2025,'Jambi','kesehatan'],

        //     ['A011','Alumni K','laki_laki','lain_lain','SMA',2021,'Sumsel','lain_lain'],
        //     ['A012','Alumni L','perempuan','wiraswasta','D3',2022,'Jambi','pertanian'],
        //     ['A013','Alumni M','laki_laki','pns','S2',2023,'Jambi','kesehatan'],
        //     ['A014','Alumni N','perempuan','mahasiswa','S1',2023,'Riau','teknologi'],
        //     ['A015','Alumni O','laki_laki','wiraswasta','SMA',2024,'Jambi','pertanian'],
        //     ['A016','Alumni P','perempuan','lain_lain','D3',2024,'Sumbar','lain_lain'],
        //     ['A017','Alumni Q','laki_laki','pns','S1',2025,'Jambi','kesehatan'],
        //     ['A018','Alumni R','perempuan','mahasiswa','SMA',2025,'Jambi','pendidikan'],
        //     ['A019','Alumni S','laki_laki','wiraswasta','S1',2023,'Jambi','teknologi'],
        //     ['A020','Alumni T','perempuan','pns','S3',2022,'Jambi','kesehatan'],
        // ];

        // $mapPekerjaan = [
        //     'mahasiswa'  => 1,
        //     'pns'        => 2,
        //     'wiraswasta' => 3,
        //     'lain_lain'  => 4,
        // ];

        // $mapPendidikan = [
        //     'SMA' => 1,
        //     'D3'  => 2,
        //     'S1'  => 3,
        //     'S2'  => 4,
        //     'S3'  => 5,
        // ];

        // $mapKeahlian = [
        //     'teknologi'  => 1,
        //     'pendidikan' => 2,
        //     'kesehatan'  => 3,
        //     'pertanian'  => 4,
        //     'lain_lain'  => 5,
        // ];

        // $tahunMin = 2021;
        // $tahunMax = 2025;

        // foreach ($data as $d) {

        //     Alumni::create([
        //         'nis' => $d[0],
        //         'nama_lengkap' => $d[1],
        //         'tanggal_lahir' => '2000-01-01',
        //         'jenis_kelamin' => $d[2],
        //         'alamat' => 'Alamat contoh',
        //         'no_telepon' => '08123456789',
        //         'email' => strtolower($d[0]).'@mail.com',
        //         'jenis_pekerjaan' => $d[3],
        //         'jenjang_pendidikan' => $d[4],
        //         'tahun_lulus' => $d[5],
        //         'domisili' => $d[6],
        //         'jenis_keahlian' => $d[7],
        //     ]);

        //     $tahunNorm = ($tahunMax - $d[5]) / ($tahunMax - $tahunMin);

        //     NumberDataAlumni::create([
        //         'nis_alumni' => $d[0],
        //         'value_jenis_pekerjaan' => $mapPekerjaan[$d[3]],
        //         'value_jenjang_pendidikan' => $mapPendidikan[$d[4]],
        //         'value_tahun_lulus' => $tahunNorm,
        //         'value_domisili' => $d[6] === 'Jambi' ? 1 : 0,
        //         'value_jenis_keahlian' => $mapKeahlian[$d[7]],
        //     ]);
        // }
    }
}
