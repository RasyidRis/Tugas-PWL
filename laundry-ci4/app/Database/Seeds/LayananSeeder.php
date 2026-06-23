<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_layanan'   => 'Cuci Setrika Kiloan (Reguler)',
                'tipe_satuan'    => 'Kg',
                'harga'          => 7000,
                'estimasi_waktu' => '2 Hari',
                'deskripsi'      => 'Layanan cuci dan setrika pakaian harian dengan pengerjaan standar 2 hari kerja.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan'   => 'Cuci Setrika Kiloan (Express)',
                'tipe_satuan'    => 'Kg',
                'harga'          => 12000,
                'estimasi_waktu' => '6 Jam',
                'deskripsi'      => 'Layanan cuci dan setrika pakaian super cepat selesai dalam waktu 6 jam saja.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan'   => 'Cuci Kering & Setrika Jas (Dry Clean)',
                'tipe_satuan'    => 'Pcs',
                'harga'          => 25000,
                'estimasi_waktu' => '3 Hari',
                'deskripsi'      => 'Layanan cuci kering dan setrika profesional untuk jas, blazer, atau pakaian formal.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan'   => 'Cuci Karpet Tebal (Bulanan)',
                'tipe_satuan'    => 'Meter',
                'harga'          => 15000,
                'estimasi_waktu' => '4 Hari',
                'deskripsi'      => 'Layanan cuci karpet tebal permeter persegi menggunakan sabun khusus anti bakteri.',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan'   => 'Cuci Bed Cover (Ukuran King)',
                'tipe_satuan'    => 'Pcs',
                'harga'          => 22000,
                'estimasi_waktu' => '2 Hari',
                'deskripsi'      => 'Layanan cuci bed cover tebal ukuran King (200x200) atau Queen (180x200).',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('layanan_laundry')->insertBatch($data);
    }
}
