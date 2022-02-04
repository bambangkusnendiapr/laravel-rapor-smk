<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(LaratrustSeeder::class);
        DB::table('groups')->insert([
            ['nama' => 'Kepesantrenan',],
            ['nama' => 'Kelompok A',],
            ['nama' => 'MULOK',],
            ['nama' => 'Kompetensi Keahlian',],
        ]);

        DB::table('majors')->insert([
            ['jurusan' => 'TKJ',],
            ['jurusan' => 'AKB',],
        ]);

        DB::table('positions')->insert([
            ['nama' => 'Guru Produktif',],
            ['nama' => 'Guru Reguler',],
            ['nama' => 'Guru Pesantren',],
        ]);

    }
}
