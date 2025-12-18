<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEducationsTable extends Migration
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
            'institution' => [
                'type'       => 'VARCHAR',
                'constraint' => 160,
            ],
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'major' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
            ],
            'start_year' => [
                'type'       => 'YEAR',
                'null'       => true,
            ],
            'end_year' => [
                'type'       => 'YEAR',
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->createTable('educations');
    }

    public function down()
    {
        $this->forge->dropTable('educations');
    }
}
