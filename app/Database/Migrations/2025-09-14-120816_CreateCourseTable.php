<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'course_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'credits' => [
                'type' => 'INT',
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('courses');
    }

    public function down()
    {
        $this->forge->dropTable('courses');
    }
}
