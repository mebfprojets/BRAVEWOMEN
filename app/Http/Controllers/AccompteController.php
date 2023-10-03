<?php

namespace App\Http\Controllers;
use App\Models\Accompte;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccompteController extends Controller
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
    public function accompte_de_la_beneficiaire(Entreprise $entreprise){
        
        $accomptes= Accompte::where("entreprise_id",$entreprise->id)->get();
       
        return view("accompte.index", compact("accomptes","entreprise"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_for_beneficiary(Entreprise $entreprise)
    {
        return view("accompte.create", compact("entreprise") );
    }
public function verifier_montant(Request $request){
        $montant= $request->montant;
        $entreprise_id= $request->entreprise_id;
        $entreprise= Entreprise::find($entreprise_id);
        $projet= $entreprise->projet;
// $request->id_contrepartie = 0 en cas de création et id de la contrepartie à modifier s'il s'agit d'une modification
if($request->id_contrepartie == 0){
    $total_montant_accompte_verse= $entreprise->accomptes()->sum('montant') + $montant;
}
else{
    $contrepartie= Accompte::find($request->id_contrepartie);
    $total_montant_accompte_verse = $entreprise->accomptes()->sum('montant') - $contrepartie->montant + $montant;
} 
     $projet_contepartie=$projet->investissementvalides->sum('apport_perso_valide');
     return ($total_montant_accompte_verse > $projet_contepartie  ) ? 1 : 0; 
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if(Auth::user()->can('enregistrer_contrepartie')){
        $entreprise=Entreprise::find($request['entreprise_id']);
        $contrepartie_total= $entreprise->accomptes->sum('montant') + reformater_montant2($request->montant);
        $montant_contrepartie = $entreprise->projet->investissementvalides->sum('apport_perso_valide');
    //     if($contrepartie_total > $montant_contrepartie){
    //         flash("Ce versement ne peut pas etre enregistrer car vous avez depasser le montant autorisé !!!")->error();
    //         return redirect()->back();   
    //     }
    // else{   
        $date= date('Y-m-d', strtotime($request->date));
            if ($request->hasFile('copie_du_recu')) {
                $copie_du_recu= $request->copie_du_recu->store('public/recu_paiement_accompte_beneficiaire');
            }
            else{
                $copie_du_recu=null;
            }
           
               Accompte::create([
                   'entreprise_id'=>$request['entreprise_id'],
                   'date_versement'=>$date,
                   'montant'=> reformater_montant2($request->montant), 
                   'copie_du_recu'=>$copie_du_recu,
                   'creerPar'=>  Auth::user()->id.''.Auth::user()->name.''.Auth::user()->prenom,
               ]);
            Insertion_Journal('Accomptes','Création');
               flash("Contrepartie enregistrer avec success !!!")->success();
               return redirect()->back();
    }
        // }
        else{
            flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
            return redirect()->back();
        }

    }
    public function editer(Request $request){
        $accompte= Accompte::find($request->id);
        $test= array('id'=>$accompte->id, 'montant'=>$accompte->montant,'date_versement'=>format_date($accompte->date_versement));
       // dd($test);
        return json_encode($test);
    }
public function modifier(Request $request){
    $accompte= Accompte::find($request->id_contrepartie);
    $date= date('Y-m-d', strtotime($request->date));
    if ($request->hasFile('copie_du_recu')) {
        $copie_du_recu= $request->copie_du_recu->store('public/recu_paiement_accompte_beneficiaire');
        $accompte->update([
            'copie_du_recu'=>$copie_du_recu,
        ]);
    }
    $accompte->update([
        'modfierPar'=> Auth::user()->id.''.Auth::user()->name.''.Auth::user()->prenom,
        'date_versement'=>$date,
        'montant'=> reformater_montant2($request->montant), 
    ]);
    Insertion_Journal('Accomptes','Modification');
    flash("Contrepartie modifié avec success !!!")->success();
    return redirect()->back();
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function show(Accompte $accompte)
    {
        //
    }
    public function get_recu(Accompte $accompt){
       // dd($accompt);
        return $path = Storage::download($accompt->copie_du_recu);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function edit(Accompte $accompte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accompte $accompte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accompte  $accompte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accompte $accompte)
    {
        //
    }
}
