<?php

use Illuminate\Database\Seeder;
use App\Invoice;
use App\Order;
use App\Service;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cuciAc = Service::where('layanan', 'like', '%Cuci AC 0.5%')->first();
        $freon  = Service::where('layanan', 'like', '%Freon%')->first();
        $bongkarPasang = Service::where('layanan', 'like', '%Bongkar Pasang%')->first();

        // Sample Invoice 1
        $kodeInvoice1 = 'INV-260910000001';
        $invoice1 = Invoice::firstOrCreate(
            ['kode_invoice' => $kodeInvoice1],
            [
                'pelanggan'   => 'Bpk. Budi Santoso',
                'alamat'      => 'Jl. Raya Serpong No. 45, Tangerang Selatan',
                'telepon'     => '081234567890',
                'keterangan'  => 'Pengerjaan cuci AC 2 unit dan isi freon R32.',
                'tempo'       => '2026-09-17',
                'pengerjaan'  => '2026-09-10',
                'teknisi'     => 'Ahmad',
                'dibayar'     => '200000',
                'total_bayar' => '265000',
                'pelunasan'   => '65000',
            ]
        );

        if ($cuciAc) {
            Order::firstOrCreate([
                'invoice_id' => $kodeInvoice1,
                'layanan_id' => $cuciAc->id,
            ], [
                'jumlah' => 2,
            ]);
        }

        if ($freon) {
            Order::firstOrCreate([
                'invoice_id' => $kodeInvoice1,
                'layanan_id' => $freon->id,
            ], [
                'jumlah' => 1,
            ]);
        }

        // Sample Invoice 2
        $kodeInvoice2 = 'INV-260910000002';
        $invoice2 = Invoice::firstOrCreate(
            ['kode_invoice' => $kodeInvoice2],
            [
                'pelanggan'   => 'Ibu Siti Rahma',
                'alamat'      => 'Komplek BSD City Cluster Flamboyan B12',
                'telepon'     => '085698765432',
                'keterangan'  => 'Bongkar pasang unit AC ke lantai 2.',
                'tempo'       => '2026-09-15',
                'pengerjaan'  => '2026-09-09',
                'teknisi'     => 'Budi',
                'dibayar'     => '225000',
                'total_bayar' => '225000',
                'pelunasan'   => '0',
            ]
        );

        if ($bongkarPasang) {
            Order::firstOrCreate([
                'invoice_id' => $kodeInvoice2,
                'layanan_id' => $bongkarPasang->id,
            ], [
                'jumlah' => 1,
            ]);
        }
    }
}
