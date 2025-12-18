<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBiodataAndSocialLinks extends Migration
{
    public function up()
    {
        $db    = \Config\Database::connect();
        $forge = $this->forge;

        if ($db->tableExists('profile') && ! $db->tableExists('biodata')) {
            $forge->renameTable('profile', 'biodata');
        }

        if (! $db->tableExists('social_links')) {
            $forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'biodata_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'label' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'url' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 60,
                    'null'       => true,
                ],
                'sort_order' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
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

            $forge->addKey('id', true);
            $forge->addKey('biodata_id');
            $forge->addKey('label');
            $forge->addForeignKey('biodata_id', 'biodata', 'id', 'CASCADE', 'CASCADE');
            $forge->createTable('social_links', true);
        }

        if ($db->fieldExists('social_links', 'biodata')) {
            $existingRows = $db->table('biodata')->select('id, social_links')->get()->getResultArray();
            foreach ($existingRows as $row) {
                if (empty($row['social_links'])) {
                    continue;
                }
                $links = json_decode($row['social_links'], true);
                if (! is_array($links)) {
                    continue;
                }
                $batch = [];
                foreach ($links as $index => $link) {
                    if (empty($link['label']) || empty($link['url'])) {
                        continue;
                    }
                    $batch[] = [
                        'biodata_id' => $row['id'],
                        'label'      => $link['label'],
                        'url'        => $link['url'],
                        'icon'       => $link['icon'] ?? 'bi-link-45deg',
                        'sort_order' => $index,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

                if (! empty($batch)) {
                    $db->table('social_links')->insertBatch($batch);
                }
            }

            $forge->dropColumn('biodata', 'social_links');
        }
    }

    public function down()
    {
        $db    = \Config\Database::connect();
        $forge = $this->forge;

        if ($db->tableExists('social_links')) {
            $forge->dropTable('social_links', true);
        }

        if ($db->tableExists('biodata') && ! $db->tableExists('profile')) {
            $forge->renameTable('biodata', 'profile');
            if (! $db->fieldExists('social_links', 'profile')) {
                $forge->addColumn('profile', [
                    'social_links' => [
                        'type' => 'TEXT',
                        'null' => true,
                        'after' => 'cv_path',
                    ],
                ]);
            }
        }
    }
}

