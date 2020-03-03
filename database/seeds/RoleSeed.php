<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Instructor']);




        Permission::create(['name' => 'Administrator']);
        Permission::create(['name' => 'Admin']);
        Permission::create(['name' => 'course.create ']);
        Permission::create(['name' => 'course.edit']);
        Permission::create(['name' => 'course.delete']);

        Permission::create(['name' => 'exam.create ']);
        Permission::create(['name' => 'exam.edit']);
        Permission::create(['name' => 'exam.delete']);

        Permission::create(['name' => 'question.create ']);
        Permission::create(['name' => 'question.edit']);
        Permission::create(['name' => 'question.delete']);

        Permission::create(['name' => 'lesson.create ']);
        Permission::create(['name' => 'lesson.edit']);
        Permission::create(['name' => 'lesson.delete']);

        Permission::create(['name' => 'topic.create ']);
        Permission::create(['name' => 'topic.edit']);
        Permission::create(['name' => 'topic.delete']);

        Permission::create(['name' => 'session.create ']);
        Permission::create(['name' => 'session.edit']);
        Permission::create(['name' => 'session.delete']);

        Permission::create(['name' => 'subject.create ']);
        Permission::create(['name' => 'subject.edit']);
        Permission::create(['name' => 'subject.delete']);

        Permission::create(['name' => 'file.view.all']);
        Permission::create(['name' => 'file.make.private']);
        Permission::create(['name' => 'file.view.private']);


        DB::table('role_has_permissions')->insert([
            'role_id' 			=> '1',
            'permission_id' 	=> '1',

        ]);
        DB::table('model_has_roles')->insert([
                'role_id' 			=> '1',
                'model_id' 			=> '1',
                'model_type'		=> 'App\User'

        ]);
    }
}
