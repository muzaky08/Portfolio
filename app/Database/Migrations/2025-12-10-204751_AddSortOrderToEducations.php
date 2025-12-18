<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSortOrderToEducations extends Migration
{
    public function up()
    {
        $field = [
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'logo',
            ],
        ];

        $this->forge->addColumn('educations', $field);
    }

    public function down()
    {
        $this->forge->dropColumn('educations', 'sort_order');
    }
}
