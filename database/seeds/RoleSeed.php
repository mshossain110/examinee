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
            
            ['name' => 'Administrator', 'slug' => 'administrator', 'description' => 'Who can do everything', 'permissions' => json_encode([ 'super.administrator' => true ]), 'status' => 1 ],
            ['name' => 'Teacher', 'slug' => 'teacher', 'description' => 'Who can perform as teacher', 'permissions' => null, 'status' => 1 ],
            ['name' => 'Student', 'slug' => 'student', 'description' => 'Who can perform as studend', 'permissions' => null, 'status' => 1 ],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
