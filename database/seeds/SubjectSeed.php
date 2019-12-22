<?php

use App\Subject;
use Illuminate\Database\Seeder;

class SubjectSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Web Design', 'Programing', 'English', 'Mathmetic', 'Robotics'];
        foreach ($name as $t ) {
            Subject::created([
                'title' => $t
            ]);
        }
        
    }
}
