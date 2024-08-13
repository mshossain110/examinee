<?php
namespace App\Models;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property int $course_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

class Role extends ModelsRole
{
    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';

    public static function appRoles(): Collection
    {
        return collect([Role::SUPERADMIN, Role::ADMIN]);
    }

    public function modifiable(): bool
    {
        return ! $this->appRoles()->include($this->name);
    }
}