<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['name' => 'Administrator', 'slug' => 'administrator'],
            ['name' => 'Teacher', 'slug' => 'teacher'],
            ['name' => 'Student', 'slug' => 'student'],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
