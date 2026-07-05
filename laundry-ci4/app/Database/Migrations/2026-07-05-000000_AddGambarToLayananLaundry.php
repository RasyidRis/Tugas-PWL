<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGambarToLayananLaundry extends Migration
{
    public function up()
    {
        $fields = [
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'deskripsi',
            ]
        ];
        $this->forge->addColumn('layanan_laundry', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('layanan_laundry', 'gambar');
    }
}
