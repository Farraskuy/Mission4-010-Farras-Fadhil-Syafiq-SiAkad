<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTakesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'course_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false
            ],
            'student_id' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => false
            ],
            'enroll_date' => [
                'type' => 'DATETIME',
                'null' => false,
            ]
        ]);

        $this->forge->addForeignKey('course_id', 'courses', 'id');
        $this->forge->addForeignKey('student_id', 'students', 'nim');
        $this->forge->createTable('takes');
    }

    public function down()
    {
        $this->forge->dropTable('takes');
    }
}
