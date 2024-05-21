<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacturePolicy
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
    public function changer_statut_facture_ou_devis(User $user){
        return $this->getPermission($user, 32);
     }
     public function payer_facture(User $user){
        return $this->getPermission($user, 33);
     }
     public function payer_a_facture(User $user){
        return $this->getPermission($user, 64);
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
