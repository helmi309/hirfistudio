<?php

use Illuminate\Database\Seeder;

class SplTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate record
        DB::table('spl')->truncate();

        $spl = [
            ['id' => 1, 'nama' => 'Fitria Maharani', 'jam_masuk' => '18:00:00', 'jam_keluar' => '23:30:00', 'pekerjaan' => 'Membuat Dokumen Penawaran Leger Jalan Kab. Banyuwangi', 'tanggal' => '2018-11-27', 'penanggung_jawab' => 'Eddu Pandika', 'pin' => '027937', 'created_at' => \Carbon\Carbon::now()],
        ];

        // Insert batch
        DB::table('spl')->insert($spl);
    }

}
