<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResidentChecklistsTables extends Migration
{
    public function up()
    {
        // 1. RESIDENT_CHECKLISTS (Sinkronisasi checklist untuk akun warga yang login)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'resident_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'guide_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addUniqueKey(['resident_user_id', 'guide_id']);
        $this->forge->addForeignKey('resident_user_id', 'resident_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('guide_id', 'service_guides', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('resident_checklists', true);

        // 2. RESIDENT_CHECKLIST_ITEMS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'checklist_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'requirement_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'is_completed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['checklist_id', 'requirement_id']);
        $this->forge->addForeignKey('checklist_id', 'resident_checklists', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('requirement_id', 'guide_requirements', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('resident_checklist_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('resident_checklist_items', true);
        $this->forge->dropTable('resident_checklists', true);
    }
}
