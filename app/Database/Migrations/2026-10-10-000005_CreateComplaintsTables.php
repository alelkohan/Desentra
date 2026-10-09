<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComplaintsTables extends Migration
{
    public function up()
    {
        // 1. COMPLAINTS (Pengaduan & Kode Tiket Unik)
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ticket_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'unique'     => true,
            ],
            'resident_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'category' => [
                'type'       => 'ENUM',
                'constraint' => ['layanan', 'infrastruktur', 'kebersihan', 'administrasi', 'lainnya'],
                'default'    => 'layanan',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'contact_reply' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true, // Opsional (No HP/WA/Email)
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['received', 'in_review', 'in_progress', 'resolved', 'rejected'],
                'default'    => 'received',
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
        $this->forge->addKey('status');
        $this->forge->addForeignKey('resident_user_id', 'resident_users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('complaints', true);

        // 2. COMPLAINT_ATTACHMENTS
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'complaint_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_size' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'mime_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('complaint_id', 'complaints', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('complaint_attachments', true);

        // 3. COMPLAINT_STATUS_HISTORY
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'complaint_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['received', 'in_review', 'in_progress', 'resolved', 'rejected'],
            ],
            'public_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'internal_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'updated_by_admin_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('complaint_id', 'complaints', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('updated_by_admin_id', 'admin_users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('complaint_status_history', true);
    }

    public function down()
    {
        $this->forge->dropTable('complaint_status_history', true);
        $this->forge->dropTable('complaint_attachments', true);
        $this->forge->dropTable('complaints', true);
    }
}
