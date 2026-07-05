<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run()
    {
        date_default_timezone_set('UTC');
        // 1. Seed Users
        $db = \Config\Database::connect();
        $db->table('users')->truncate();
        
        $users = [
            [
                'username'   => 'admin',
                'email'      => 'admin@laundry.com',
                'password'   => password_hash('admin101', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'kasir',
                'email'      => 'kasir@laundry.com',
                'password'   => password_hash('kasir123', PASSWORD_DEFAULT),
                'role'       => 'kasir',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $db->table('users')->insertBatch($users);

        // 2. Seed Members
        $db->table('members')->truncate();
        $members = [
            ['nama' => 'Agus Hartono', 'telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 10, Jakarta', 'poin' => 15, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Siti Aminah', 'telepon' => '082345678901', 'alamat' => 'Jl. Mawar No. 4, Bandung', 'poin' => 8, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Maya Indah', 'telepon' => '083456789012', 'alamat' => 'Jl. Melati No. 12, Surabaya', 'poin' => 20, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Rina Kartika', 'telepon' => '084567890123', 'alamat' => 'Jl. Dahlia No. 15, Semarang', 'poin' => 5, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Budi Santoso', 'telepon' => '085678901234', 'alamat' => 'Jl. Anggrek No. 8, Yogyakarta', 'poin' => 12, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Dewi Lestari', 'telepon' => '086789012345', 'alamat' => 'Jl. Kenanga No. 22, Solo', 'poin' => 9, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Ahmad Fauzi', 'telepon' => '087890123456', 'alamat' => 'Jl. Kamboja No. 7, Malang', 'poin' => 30, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Citra Lestari', 'telepon' => '088901234567', 'alamat' => 'Jl. Bougenville No. 30, Bogor', 'poin' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $db->table('members')->insertBatch($members);

        // 3. Ensure Services are Seeded
        $layananCount = $db->table('layanan_laundry')->countAllResults();
        if ($layananCount == 0) {
            $seeder = \Config\Database::seeder();
            $seeder->call('LayananSeeder');
        }

        // 4. Seed Transactions
        $db->table('transaksi')->truncate();
        $db->table('transaksi_detail')->truncate();
        $db->table('keuangan')->truncate();

        // Active Queue 1: Agus Hartono
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-001',
            'member_id' => 1,
            'status' => 'Cuci',
            'total_harga' => 35000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
        ]);
        $t1_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t1_id,
            'layanan_id' => 1, // Cuci Setrika Kiloan Reguler (7000)
            'jumlah' => 5.00,
            'subtotal' => 35000
        ]);

        // Active Queue 2: Siti Aminah
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-002',
            'member_id' => 2,
            'status' => 'Cuci',
            'total_harga' => 50000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1.5 hours')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1.5 hours'))
        ]);
        $t2_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t2_id,
            'layanan_id' => 3, // Dry Clean (25000)
            'jumlah' => 2.00,
            'subtotal' => 50000
        ]);

        // Active Queue 3: Maya Indah
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-003',
            'member_id' => 3,
            'status' => 'Cuci',
            'total_harga' => 60000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
        ]);
        $t3_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t3_id,
            'layanan_id' => 2, // Express (12000)
            'jumlah' => 5.00,
            'subtotal' => 60000
        ]);

        // Active Queue 4: Rina Kartika
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-004',
            'member_id' => 4,
            'status' => 'Cuci',
            'total_harga' => 44000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-45 mins')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-45 mins'))
        ]);
        $t4_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t4_id,
            'layanan_id' => 5, // Bed Cover King (22000)
            'jumlah' => 2.00,
            'subtotal' => 44000
        ]);

        // Active Queue 5: Agus Hartono (Hold)
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-005',
            'member_id' => 1,
            'status' => 'Hold',
            'total_harga' => 14000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-30 mins')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-30 mins'))
        ]);
        $t5_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t5_id,
            'layanan_id' => 1, // Reguler (7000)
            'jumlah' => 2.00,
            'subtotal' => 14000
        ]);

        // Active Queue 6: Budi Santoso (Dalam Proses)
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-006',
            'member_id' => 5,
            'status' => 'Dalam Proses',
            'total_harga' => 45000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-20 mins')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-20 mins'))
        ]);
        $t6_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t6_id,
            'layanan_id' => 4, // Karpet (15000)
            'jumlah' => 3.00,
            'subtotal' => 45000
        ]);

        // Active Queue 7: Dewi Lestari (Hold)
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-007',
            'member_id' => 6,
            'status' => 'Hold',
            'total_harga' => 25000,
            'bayar' => 0,
            'status_bayar' => 'Belum Lunas',
            'created_at' => date('Y-m-d H:i:s', strtotime('-10 mins')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-10 mins'))
        ]);
        $t7_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t7_id,
            'layanan_id' => 3, // Dry Clean (25000)
            'jumlah' => 1.00,
            'subtotal' => 25000
        ]);

        // Paid Transaction for today to make Omset Hari Ini = 150.000
        $db->table('transaksi')->insert([
            'no_antrian' => 'Q-008',
            'member_id' => 7,
            'status' => 'Diambil',
            'total_harga' => 150000,
            'bayar' => 150000,
            'status_bayar' => 'Lunas',
            'completed_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
        ]);
        $t8_id = $db->insertID();
        $db->table('transaksi_detail')->insert([
            'transaksi_id' => $t8_id,
            'layanan_id' => 3, // Dry Clean (25000)
            'jumlah' => 6.00,
            'subtotal' => 150000
        ]);

        // Financial log for today's paid transaction
        $db->table('keuangan')->insert([
            'transaksi_id' => $t8_id,
            'tipe' => 'masuk',
            'jumlah' => 150000,
            'keterangan' => 'Pembayaran Antrian Q-008',
            'tanggal' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            'updated_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
        ]);
    }
}
