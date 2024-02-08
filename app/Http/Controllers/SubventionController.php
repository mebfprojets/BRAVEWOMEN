<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Subvention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class SubventionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function subvention_de_la_beneficiaire(Entreprise $entreprise){
        $subventions= Subvention::where("entreprise_id",$entreprise->id)->get();
        return view("subvention.index", compact("subventions","entreprise"));
    }
    public function create_for_beneficiary(Entreprise $entreprise)
    {
        return view("accompte.create", compact("entreprise") );
    }
    public function valider_montant(Request $request){
        $montant_subvention=$request->montant;
        $entreprise= Entreprise::find($request->id_entreprise);
      // dd($request->id_subvention);
        if($request->id_subvention == 0){
            $total_subvention= $entreprise->subventions->sum('montant_subvention') + $montant_subvention;
        }
        else{
            $subvention= Subvention::find($request->id_subvention);
            $total_subvention= $entreprise->subventions->sum('montant_subvention') - $subvention->montant_subvention + $montant_subvention;
        }
        $contrepartie_versee = $entreprise->accomptes->sum('montant');
        $subvention_accorde=$entreprise->projet->investissementvalides->sum('subvention_demandee_valide');
        return (($total_subvention > $subvention_accorde)|| ($total_subvention > $contrepartie_versee)) ? 2 : 0;  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     if(Auth::user()->can('enregistrer_subvention')){
        $entreprise=Entreprise::find($request['entreprise_id']);
        $subvention_total= $entreprise->subventions->sum('montant_subvention') + reformater_montant2($request->montant);
        $montant_subvention_accorde = $entreprise->projet->investissementvalides->sum('subvention_demandee_valide');
        if($subvention_total > $montant_subvention_accorde){
            flash("Ce versement ne peut pas etre enregistré car vous avez depasser le montant autorisé !!!")->error();
            return redirect()->back();   
        }
    else{
        $date= date('Y-m-d', strtotime($request->date));
        if ($request->hasFile('copie_du_recu')) {
            $copie_du_recu= $request->copie_du_recu->store('public/recu_subvention_beneficiaire');
        }
        else{
            $copie_du_recu='recu non fourni';
        }
           Subvention::create([
               'entreprise_id'=>$request['entreprise_id'],
               'date_subvention'=>$date,
               'montant_subvention'=> reformater_montant2($request->montant), 
               'copie_recu'=>$copie_du_recu,
               'creerPar'=> Auth::user()->id.''.Auth::user()->name.''.Auth::user()->prenom,
           ]);
           Insertion_Journal('Subventions','Création');

           flash("Subvention enregistrée avec success !!!")->success();
           return redirect()->back();
        }
        }
        else{
            flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
            return redirect()->back();
        }
}

   public function editer(Request $request){
        $subvention= Subvention::find($request->id);
        $test= array('id'=>$subvention->id, 'montant'=>$subvention->montant_subvention,'date_subvention'=>format_date($subvention->date_subvention));
        return json_encode($test);
   }
   public function modifier(Request $request){
    $subvention= Subvention::find($request->id_subvention);
    $date= date('Y-m-d', strtotime($request->date));
    if ($request->hasFile('copie_du_recu')) {
        $copie_du_recu= $request->copie_du_recu->store('public/recu_subvention_beneficiaire');
        $subvention->update([
            'copie_recu'=>$copie_du_recu,
        ]);
    }
    $subvention->update([
        'date_subvention'=>$date,
        'modfierPar'=> Auth::user()->id.''.Auth::user()->name.''.Auth::user()->prenom,
        'montant_subvention'=> reformater_montant2($request->montant), 
    ]);
    Insertion_Journal('Subventions','Modification');
    flash("Subvention modifiée  avec success !!!")->success();
    return redirect()->back();
}
    public function get_recu(Subvention $subvention){
         return $path = Storage::download($subvention->copie_du_recu);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subvention  $subvention
     * @return \Illuminate\Http\Response
     */
    public function show(Subvention $subvention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subvention  $subvention
     * @return \Illuminate\Http\Response
     */
    public function edit(Subvention $subvention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subvention  $subvention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subvention $subvention)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subvention  $subvention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subvention $subvention)
    {
        //
    }
}
