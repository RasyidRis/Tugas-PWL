<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeuanganTable extends Migration
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
                'null'       => true,
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'jumlah' => [
                'type'       => 'INT',
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('keuangan');
    }

    public function down()
    {
        $this->forge->dropTable('keuangan');
    }
}
