<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        KategoriProduk::truncate();
        $Kategori = new KategoriProduk();
        $Kategori->name = 'Air Mineral';
        $Kategori->save();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
