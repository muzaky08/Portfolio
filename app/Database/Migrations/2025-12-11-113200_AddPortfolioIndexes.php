<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPortfolioIndexes extends Migration
{
    public function up()
    {
        $this->ensureIndex('activities', 'idx_activities_activity_date', ['activity_date']);
        $this->ensureIndex('activities', 'idx_activities_category', ['category']);
        $this->ensureIndex('activities', 'idx_activities_title', ['title']);

        $this->ensureIndex('educations', 'idx_educations_level', ['level']);
        $this->ensureIndex('educations', 'idx_educations_start_year', ['start_year']);

        $this->ensureIndex('skills', 'idx_skills_name', ['name']);
        $this->ensureIndex('skills', 'idx_skills_category', ['category']);

        $this->ensureIndex('projects', 'idx_projects_completed_at', ['completed_at']);
    }

    public function down()
    {
        $this->dropIndexIfExists('activities', 'idx_activities_activity_date');
        $this->dropIndexIfExists('activities', 'idx_activities_category');
        $this->dropIndexIfExists('activities', 'idx_activities_title');

        $this->dropIndexIfExists('educations', 'idx_educations_level');
        $this->dropIndexIfExists('educations', 'idx_educations_start_year');

        $this->dropIndexIfExists('skills', 'idx_skills_name');
        $this->dropIndexIfExists('skills', 'idx_skills_category');

        $this->dropIndexIfExists('projects', 'idx_projects_completed_at');
    }

    private function ensureIndex(string $table, string $indexName, array $columns): void
    {
        $db = \Config\Database::connect();
        $exists = $db->query('SHOW INDEX FROM ' . $db->protectIdentifiers($table) . ' WHERE Key_name = ?', [$indexName])->getResultArray();
        if (! empty($exists)) {
            return;
        }

        $columnsSql = implode(',', array_map(static fn ($col) => $db->protectIdentifiers($col), $columns));
        $db->query(sprintf(
            'CREATE INDEX %s ON %s (%s)',
            $db->protectIdentifiers($indexName),
            $db->protectIdentifiers($table),
            $columnsSql
        ));
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        $db = \Config\Database::connect();
        $exists = $db->query('SHOW INDEX FROM ' . $db->protectIdentifiers($table) . ' WHERE Key_name = ?', [$indexName])->getResultArray();
        if (empty($exists)) {
            return;
        }

        $db->query(sprintf(
            'DROP INDEX %s ON %s',
            $db->protectIdentifiers($indexName),
            $db->protectIdentifiers($table)
        ));
    }
}

