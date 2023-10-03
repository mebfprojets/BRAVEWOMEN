<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BanquePolicy
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
    public function view(User $user)
    {
        return $this->getPermission($user,10);
    }
    public function enregistrer_contrepartie(User $user)
    {
        return $this->getPermission($user,50);
    }
    public function enregistrer_subvention(User $user)
    {
        return $this->getPermission($user,51);
    }
    public function enregistrer_paiement(User $user)
    {
        return $this->getPermission($user,52);
    }
    

    public function create(User $user)
    {
        return $this->getPermission($user,3);
    }
    public function update(User $user)
    {
        return $this->getPermission($user,5);
    }
    public function dashboard_bank(User $user)
    {
        return $this->getPermission($user,47);
    }
    public function lister_client_bank(User $user)
    {
        return $this->getPermission($user,48);
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
