<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
        public function create(User $user)
    {
        return $this->getPermission($user,61);
    }
        public function update(User $user)
    {
        return $this->getPermission($user,62);
    }
        public function view(User $user)
    {
        return $this->getPermission($user, 63);
    }
    public function getPermission($user,$permission_id){
        foreach($user->roles as $user_role){
            foreach($user_role->permissions as $permission_role){
                if($permission_role->id == $permission_id){
                    return true;
                }
        }
    }
    return false;
}
}
