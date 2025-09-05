<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        //  Add new 'name' column
        $this->forge->addColumn('users', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);

        //  Modify 'role' enum values
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default'    => 'user',
            ],
        ]);
    }

    public function down()
    {
        // Rollback changes
        // Drop the 'name' column
        $this->forge->dropColumn('users', 'name');

        // Restore old role
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['Student', 'Instructor', 'Admin'],
                'default'    => 'Student',
            ],
        ]);
    }
}
