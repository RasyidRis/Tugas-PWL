<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'transaksi_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'layanan_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'jumlah' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'subtotal' => [
                'type'       => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi_detail');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_detail');
    }
}
