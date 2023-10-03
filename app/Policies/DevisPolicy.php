<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevisPolicy
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
    public function lister_devis_soumis(User $user){
        return $this->getPermission($user, 29);
     }
     public function lister_devis_transmis_au_pm(User $user){
        return $this->getPermission($user, 30);
     }
     public function lister_all_devis(User $user){
        return $this->getPermission($user, 31);
     }
     public function analyser_devis(User $user){
        return $this->getPermission($user, 31);
     }
     public function update_devis_execution(User $user){
        return $this->getPermission($user, 57);
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
