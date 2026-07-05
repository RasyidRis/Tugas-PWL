<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayananLaundryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_layanan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipe_satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'harga' => [
                'type'       => 'INT',
            ],
            'estimasi_waktu' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('layanan_laundry');
    }

    public function down()
    {
        $this->forge->dropTable('layanan_laundry');
    }
}
