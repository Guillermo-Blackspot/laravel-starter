<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $guard_name = 'web';
    public const SUPER_ADMIN_PERMISSION = 'im-a-super-admin-and-i-have-full-access';
}
