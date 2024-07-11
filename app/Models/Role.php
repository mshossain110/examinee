<?php
namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';
}