<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EntrepriseController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);
        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'user is registred successufully'
        ]);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user=User::where('email', $request->email)->first();
        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                    $token=$user->createToken('myToken')->plainTextToken;
                    return response()->json([
                        'status'=>true,
                        'message'=>'Connecter avec success',
                        'token'=>$token,
               
                    ]);
            }
            return response()->json([
                'status'=>false,
                'message'=>'Mot de passe incorrect'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'Cet utilisateur nexiste pas dans la base de donne'
        ]);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
                'status'=>true,
                'message'=>'user logged out'
        ]);
}
    public function getEntrepriseParCodePromoteur( Request $request){
            //$nom_prom= $entreprise->promoteur->nom.$entreprise->promoteur->prenom;
            try{
            $entreprise= Entreprise::where('code_promoteur', $request->code)->first();

                if($entreprise)
                {
                $entreprise_info= array('denomination'=>$entreprise->denomination, 'region'=>getlibelle($entreprise->region),'province'=>getlibelle($entreprise->province),'commune'=>getlibelle($entreprise->commune),'secteurOuVillage'=>getlibelle($entreprise->arrondissement),'secteur_dactivite'=>getlibelle($entreprise->secteur_activite),'maillon'=>getlibelle($entreprise->maillon_activite),'nom_promoteur'=>$entreprise->promotrice->nom.' '.$entreprise->promotrice->prenom );
                    return response()->json([
                        'status'=>200,
                        'message'=>'Informations sur entreprise',
                        'data'=>$entreprise_info
                    ]);
                } 
                else
                {
                    return response()->json([
                        'status'=>False,
                        'message'=>'Ce code promoteur ne retourne pas entreprise',
                        
                    ]);
                }
            }
            catch(Exception $e){
                return response()->json($e);
            }  
    }
}
