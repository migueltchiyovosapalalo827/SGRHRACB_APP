<?php

namespace App\Models\Traits;

use App\Models\Tenant;

trait UserACLTrait
{
    public function permissions(): array
    {

        $permissionsRole = $this->permissionsRole();
        $permissions = [];

        foreach ($permissionsRole as $permission) {

                array_push($permissions, $permission);
        }

        return $permissions;
    }



    public function permissionsRole(): array
    {
        $roles = $this->cargos()->with('permissoes')->get();

        $permissoes = [];
        foreach ($roles as $role) {
            foreach ($role->permissoes as $permission) {
                array_push($permissoes, $permission->name);
            }
        }

        return $permissoes;
    }

    public function hasPermission(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissions());
    }

    public function isAdmin(): bool
    {
        return in_array($this->email,['miguelsapalomiguel@17gmail.com']);
    }


}
