<?php

use Illuminate\Database\Seeder;
use App\Topic;

class TopicSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Topic::class, 15)->create();
    }
}
