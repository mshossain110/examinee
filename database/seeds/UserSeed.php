<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'firstname'      => 'admin' ,
                'lastname'       => null,
                'avatar'         => 'http://lorempixel.com/80/60/',
                'name'           => 'admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$l4MghrLnKXTRUDlR07XQeesKHRIaAe7WzDf90g751BEf70AwnJ5m.',// password
                'remember_token' => Str::random(10)
            ],
            [
                'firstname'      => 'Teacher' ,
                'lastname'       => null,
                'avatar'         => 'http://lorempixel.com/80/60/',
                'name'           => 'teacher',
                'email'          => 'teacher@admin.com',
                'password'       => '$2y$10$l4MghrLnKXTRUDlR07XQeesKHRIaAe7WzDf90g751BEf70AwnJ5m.',// password
                'remember_token' => Str::random(10)
            ],
            [
                'firstname'      => 'Student' ,
                'lastname'       => null,
                'avatar'         => 'http://lorempixel.com/80/60/',
                'name'           => 'student',
                'email'          => 'student@admin.com',
                'password'       => '$2y$10$l4MghrLnKXTRUDlR07XQeesKHRIaAe7WzDf90g751BEf70AwnJ5m.',// password
                'remember_token' => Str::random(10)
            ]
        ];

        foreach ($items as $key => $item) {
            $user = User::create($item);
        }

        factory(User::class, 10)->create();
    }
}
