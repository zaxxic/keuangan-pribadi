<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            ['title' => 'Paket 1 Bulan', 'amount' => 90000,'bonus' => 'Gratis 1 Bulan',],
            ['title' => 'Paket Tahunanan', 'amount' => 400000,'bonus' => 'Gratis 5 Bulan'],
            ['title' => 'Paket 6 Bulan', 'amount' => 200000,'bonus' => 'Gratis 3 Bulan'],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        // Memasukkan data ke dalam tabel packages menggunakan metode create
        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
