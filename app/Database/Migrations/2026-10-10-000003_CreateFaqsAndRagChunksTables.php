<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqsAndRagChunksTables extends Migration
{
    public function up()
    {
        // 1. FAQS
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'service_guide_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'question' => [
                'type'       => 'VARCHAR',
                'constraint' => 300,
            ],
            'answer' => [
                'type' => 'TEXT',
            ],
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Umum',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'pending_verification', 'published', 'needs_review', 'archived'],
                'default'    => 'draft',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'verified_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addKey('status');
        $this->forge->addForeignKey('service_guide_id', 'service_guides', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'admin_users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('verified_by', 'admin_users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('faqs', true);

        // 2. FAQ_SOURCES
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'faq_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'source_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('faq_id', 'faqs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('source_id', 'content_sources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('faq_sources', true);

        // 3. GUIDE_CHUNKS (Untuk RAG semantic/keyword search)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'guide_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'faq_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'chunk_text' => [
                'type' => 'TEXT',
            ],
            'keywords' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'token_count' => [
                'type'       => 'INT',
                'constraint' => 6,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('guide_id', 'service_guides', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('faq_id', 'faqs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('guide_chunks', true);

        // 4. RESIDENT_QUESTIONS
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'resident_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'session_uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
            ],
            'question_text' => [
                'type' => 'TEXT',
            ],
            'answer_text' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_fallback' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['answered', 'needs_review', 'resolved'],
                'default'    => 'answered',
            ],
            'confidence_score' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('session_uuid');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('resident_user_id', 'resident_users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('resident_questions', true);

        // 5. QUESTION_SOURCES (Sitasi sumber yang benar-benar digunakan AI)
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'question_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'chunk_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'citation_text' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_id', 'resident_questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('chunk_id', 'guide_chunks', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('question_sources', true);

        // 6. QUESTION_FEEDBACK
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'question_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],
            'guide_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'rating' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'default'    => 1, // 1 = helpful, -1 = unhelpful
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_id', 'resident_questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('guide_id', 'service_guides', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('question_feedback', true);
    }

    public function down()
    {
        $this->forge->dropTable('question_feedback', true);
        $this->forge->dropTable('question_sources', true);
        $this->forge->dropTable('resident_questions', true);
        $this->forge->dropTable('guide_chunks', true);
        $this->forge->dropTable('faq_sources', true);
        $this->forge->dropTable('faqs', true);
    }
}
