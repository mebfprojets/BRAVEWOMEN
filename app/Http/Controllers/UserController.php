<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Entreprise;
use App\Models\Promotrice;
use App\Models\Role;
use App\Models\User;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(["verifier_conformite_cpt",'storecomptePromoteur']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users= User::with("roles")->orderBy('updated_at', 'desc')->get();
        return view('users.index', compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles= Role::all();
        $zones=Valeur::where('parametre_id',1 )->whereIn('id', [env('VALEUR_ID_CENTRE'),env('VALEUR_ID_HAUT_BASSIN'), env('VALEUR_ID_BOUCLE_DU_MOUHOUN'), env('VALEUR_ID_NORD')])->get();
        $strucure_representees=Valeur::where('parametre_id',env("PARAMETRE_ID_REPRESENTANT_STRUCTURE") )->get();
        $banques= Banque::all();
        return view("users.create", compact("roles", "zones","strucure_representees", "banques"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            "nom"=>"required",
            "email"=>"required|email"
        ]);
        if(isset($request['structure_rep'])){
            $structure_represente=$request['structure_rep'];
        }
        else{
            $structure_represente=0;
        }
       $user= User::create([
            "name"=>$request['nom'],
            "email"=>$request['email'],
            'prenom'=> $request ['prenom'],
            'zone' => $request ['organisation'],
            'telephone'=> $request ['telephone'],
            'email' => $request['email'],
            'structure_represente'=>$structure_represente,
            'firstcon' => 1,
            'banque_id'=>$request['banque'],
            'password' => bcrypt('bwburkina@2022')
        ]);
        $user->roles()->sync($request->roles);
        return redirect()->route("user.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $zones=Valeur::where('parametre_id',1 )->whereIn('id', [env('VALEUR_ID_CENTRE'),env('VALEUR_ID_HAUT_BASSIN'), env('VALEUR_ID_BOUCLE_DU_MOUHOUN'), env('VALEUR_ID_NORD')])->get();
        //$zones= Valeur::where("parametre_id",env("PRARAMETRE_ZONE"))->get();
        $roles=Role::all();
        $strucure_representees=Valeur::where('parametre_id',env("PARAMETRE_ID_REPRESENTANT_STRUCTURE") )->get();
        $banques= Banque::all();
        return view("users.update",compact(["user","roles","zones","strucure_representees","banques"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom'=>"required",
            'email'=>"required|email"
        ]);
        if($request['structure_rep'] == ""){
            $structure_represente=0;
        }
        else{
            $structure_represente=$request['structure_rep'];
        }
        $user->update([
            "name"=>$request['nom'],
            "email"=>$request['email'],
            'prenom'=> $request ['prenom'],
            'zone' => $request ['organisation'],
            'telephone'=> $request ['telephone'],
            'email' => $request['email'],
            'banque_id'=>$request['banque'],
            'structure_represente'=>$structure_represente,
        ]);
        $user->roles()->sync($request->roles);
        return redirect()->route("user.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
public function updateuser(Request $request, User $user)
        {
            $user->update([
                    'name' => $request ['nom'],
                    'prenom'=> $request ['prenom'],
                    'telephone'=> $request ['telephone'],
                    'email' => $request['email']
                ]);

            if(!empty($request['password']))
            {
                $user->update([
                    'password' => bcrypt($request['password'])
                ]);
            }
            return redirect()->back();
}
public function verifier_conformite_cpt(Request $request){ 
    $entreprises=Entreprise::where('code_promoteur',$request->code_promoteur)->get();
    $user=User::where("code_promoteur",$request->code_promoteur)->first();
    if(!$entreprises || $user){
        return 2;
    }
    elseif(count($entreprises)>0){
        return 1;
    }else{
        return 0;
    }

}
public function storecomptePromoteur(Request $request){
    $request->validate([
        'code_promoteur'=>'unique:users|max:255',
    ]);
    $promoteur=Promotrice::where('code_promoteur',$request->code_promoteur)->first();
    if(isset($request['code_promoteur'], $request['email'])){
        $user= User::create([
            "name"=>$promoteur['nom'],
            "email"=>$request['email'],
            'prenom'=> $promoteur['prenom'],
            'telephone'=> $request ['telephone'],
            'email' => $request['email'],
            'code_promoteur' => $request['code_promoteur'],
            'password' => bcrypt($request['password'])
        ]);
    }
    
    return redirect()->back();
    
}
public function logout(Request $request) {
   
    if(Auth::user()->code_promoteur==null){
        Auth::logout();
        return redirect()->route('login');
    }
    else{
        Auth::logout();
        return redirect()->route('accueil');
    }
   
}

}
