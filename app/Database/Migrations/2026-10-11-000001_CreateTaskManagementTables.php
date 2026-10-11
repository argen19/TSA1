<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;

class CreateTaskManagementTables extends Migration
{
    public function up()
    {
        // This is a separate assessment database, not an upgrade of a POS database.
        // Check both names before creating anything; never replace existing tables.
        if ($this->db->tableExists('tasks') || $this->db->tableExists('users')) {
            throw new RuntimeException('Use a new, empty TSA1 database. If you already imported database/tsa1.sql, skip migrations. Existing tables have not been changed.');
        }

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending', 'null' => false],
            'task_date' => ['type' => 'DATE', 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tasks');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'full_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users');
    }

    public function down()
    {
        // Only run migration rollback when deliberately removing this assessment DB.
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('tasks', true);
    }
}
