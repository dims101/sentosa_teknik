<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'layanan' => 'Cuci AC 0.5 - 1 PK',
                'harga' => '75000',
                'promo' => '65000',
                'keterangan' => 'Layanan pembersihan unit indoor & outdoor AC kapasitas 0.5 - 1 PK.',
            ],
            [
                'layanan' => 'Cuci AC 1.5 - 2 PK',
                'harga' => '90000',
                'promo' => '80000',
                'keterangan' => 'Layanan pembersihan unit indoor & outdoor AC kapasitas 1.5 - 2 PK.',
            ],
            [
                'layanan' => 'Isi Freon R22 / R32 / R410a',
                'harga' => '150000',
                'promo' => '135000',
                'keterangan' => 'Pengisian ulang freon AC sesuai tipe freon.',
            ],
            [
                'layanan' => 'Bongkar Pasang AC',
                'harga' => '250000',
                'promo' => '225000',
                'keterangan' => 'Jasa bongkar pasang unit AC ke lokasi baru.',
            ],
            [
                'layanan' => 'Perbaikan & Perawatan AC',
                'harga' => '100000',
                'promo' => '0',
                'keterangan' => 'Pemeriksaan dan perbaikan masalah kelistrikan/bocor AC.',
            ],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(
                ['layanan' => $data['layanan']],
                $data
            );
        }
    }
}
