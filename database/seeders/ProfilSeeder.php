<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set('Asia/Jakarta');
        
        DB::table('tb_profil')->insert([
            'id' => '1',
            'nama_web' => 'MTs NEGERI 1 KEBUMEN',
            'jenjang' => '3',
            'logo_web' => '',
            'logo_admin' => '',
            'favicon' => '',
            'meta_description' => 'Selamat datang di website MTs NEGERI 1 KEBUMEN',
            'meta_keyword' => 'MTs NEGERI 1 KEBUMEN',
            'profil' => '',
            'alamat' => 'Jl. Tentara Pelajar No 29 Kebumen 54312',
            'email' => 'mtsnkebumen1@kemenag.go.id',
            'telp' => '(0287) 381229',
            'fax' => '-',
            'whatsapp' => '',
            'akreditasi' => 'A',
            'kurikulum' => 'Kurikulum 2013',
            'file' => '',
            'nama_kepsek' => '-',
            'nama_operator' => '-',
            'instagram' => 'https://www.instagram.com/mtsn1kebumen',
            'facebook' => 'https://web.facebook.com/profile.php?id=100067035564396',
            'twitter' => 'https://mobile.twitter.com/kebumen_1',
            'youtube' => 'https://www.youtube.com/channel/UCp_1yWIfzQ1i-tEW06BHhrA',
            'gambar' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

}