<?php

namespace Tests\Unit;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CreateUserTableMigrationTest extends TestCase
{
    public function test_users_table_columns()
    {

        $this->assertTrue(Schema::hasTable('users'), 'Users table does not exist');

        $columns = [
            'id',
            'prefixname',
            'firstname',
            'middlename',
            'lastname',
            'suffixname',
            'username',
            'email',
            'email_verified_at',
            'password',
            'photo',
            'type',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('users', $column),
                "Failed asserting that column '{$column}' exists in 'users' table"
            );
        }
    }
}
