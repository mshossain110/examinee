<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);
        $this->call(RoleSeedPivot::class);
        $this->call(UserSeedPivot::class);
        $this->call(CourseSeed::class);
    }
}
