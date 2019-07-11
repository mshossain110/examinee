<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['title' => 'user_management_access',],
            ['title' => 'user_management_create',],
            ['title' => 'user_management_edit',],
            ['title' => 'user_management_view',],
            ['title' => 'user_management_delete',],
            ['title' => 'permission_access',],
            ['title' => 'permission_create',],
            ['title' => 'permission_edit',],
            ['title' => 'permission_view',],
            [ 'title' => 'permission_delete',],
            [ 'title' => 'role_access',],
            [ 'title' => 'role_create',],
            [ 'title' => 'role_edit',],
            [ 'title' => 'role_view',],
            [ 'title' => 'role_delete',],
            [ 'title' => 'user_access',],
            [ 'title' => 'user_create',],
            [ 'title' => 'user_edit',],
            [ 'title' => 'user_view',],
            [ 'title' => 'user_delete',],
            [ 'title' => 'course_access',],
            [ 'title' => 'course_create',],
            [ 'title' => 'course_edit',],
            [ 'title' => 'course_view',],
            [ 'title' => 'course_delete',],
            [ 'title' => 'lesson_access',],
            [ 'title' => 'lesson_create',],
            [ 'title' => 'lesson_edit',],
            [ 'title' => 'lesson_view',],
            [ 'title' => 'lesson_delete',],
            [ 'title' => 'question_access',],
            [ 'title' => 'question_create',],
            [ 'title' => 'question_edit',],
            [ 'title' => 'question_view',],
            [ 'title' => 'question_delete',]

        ];

        foreach ($items as $item) {
            \App\Permission::create($item);
        }
    }
}
