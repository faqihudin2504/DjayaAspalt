<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemesananJasaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'no_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'tanggal_waktu' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'alamat' => [
                'type' => 'TEXT'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pemesanan_jasa');
    }

    public function down()
    {
        $this->forge->dropTable('pemesanan_jasa');
    }
}