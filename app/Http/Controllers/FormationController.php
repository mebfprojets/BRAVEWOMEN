<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Formation;
use App\Models\ParticipantFormation;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormationController extends Controller
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
        if (Auth::user()->can('formation.listerFormation'))
        {
            $formations= Formation::where("zone_concernee", Auth::user()->zone)->orderBy('created_at','desc')->get();
            return view("formations.index", compact("formations"));
        }
        return redirect()->back();
    }
    public function liste_formation(){
        $formations = Formation::all();
        return view("formations.allsessions", compact("formations"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('formation.listerFormation'))
        {
            $type_formations= Valeur::where("parametre_id",30)->get();
            return view("formations.create", compact("type_formations"));
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('formation.listerFormation'))
        {
        Formation::create([
            "libelle"=>$request->libelle,
            "type"=>$request->type_formation,
            "date_debut"=>$request->date_debut,
            "date_fin"=>$request->date_fin,
            "zone_concernee"=>Auth::user()->zone,
       ]);
        flash("Formation créée avec success !!!")->success();
        return redirect()->route("formation.index");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function show(Formation $formation)
    {
        
        $participants= ParticipantFormation::where('formation_id', $formation->id)->get('entreprise_id');
        $id_participants=[];
        $i=0;
        foreach($participants as $participant){
            $id_participants[$i]=$participant->entreprise_id;
            $i++;

        }
        $participants = Entreprise::whereIn('id',$id_participants)->get();
   
        return view("formations.show", compact('formation','participants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function edit(Formation $formation)
    {
        if (Auth::user()->can('formation.modifier'))
        {
            $type_formations= Valeur::where("parametre_id",30)->get();
        // $participants = ParticipantFormation::where("formation_id", $formation->id)->get();
            return view("formations.update", compact("type_formations", "formation"));
        }else{
            flash("Vous n'avez pas le droit d'effectuer cette opération. Contactez l'administrateur !!!")->error();
            return redirect()->back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formation $formation)
    {
        if (Auth::user()->can('formation.modifier'))
        {
        if ($request->hasFile('listedepresence')) {
            $urllistedepresence= $request->listedepresence->store('public/listedepresenceformation');
        }
        else{
            $urllistedepresence= "";
        }
            $formation->update([
                "libelle"=>$request->libelle,
                "type"=>$request->type_formation,
                "date_debut"=>$request->date_debut,
                "date_fin"=>$request->date_fin,
                'url_liste_presence'=>$urllistedepresence,
        ]);
        flash("Modification effectuée avec success !!!")->success();
        return redirect()->route("formation.index");
    }
    else{
        flash("Vous n'avez pas le droit de modifier une formation.Bien vouloir contacter l'administrateur")->error();
        return redirect()->back();
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formation $formation)
    {
        //
    }
    public function ajouter_participants(Formation $formation, Request $request){
        if (Auth::user()->can('formation.modifier'))
        {
            $formation_programmees= ParticipantFormation::all();
            $id_entreprises=[];
            $i=0;
        if($formation_programmees != null){
        foreach($formation_programmees as $formation_programmee)
        {
            $id_entreprises[$i]= $formation_programmee->entreprise_id;
            $i++;
        }
    }
    if($request->typeentreprise=='mpme'){
    // Recuperer la liste des entreprises rétenues pour la formation 
        $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")
                                    //->where('participer_a_la_formation',null)
                                    ->where('aopOuleader',null)
                                    ->Where(function ($query) {
                                        $query->orwhere('region',Auth::user()->zone)
                                        ->orwhere('region_affectation', Auth::user()->zone);
                                    })
                                    ->orderBy('updated_at', 'desc')->get();
       
    //dans liste des entreprises retenues exclure la liste des entreprises qui sont deja programmées pour une session
    } else{
        $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")
                                    ->where('entrepriseaop',"!=",null)
                                    //->where('participer_a_la_formation',null)
                                    ->Where(function ($query) {
                                        $query->orwhere('region',Auth::user()->zone)
                                        ->orwhere('region_affectation', Auth::user()->zone);
                                    })->orderBy('updated_at', 'desc')->get();
       
    }

        $entreprises_retenues= $entreprises->except($id_entreprises);
    $participants = ParticipantFormation::where("formation_id", $formation->id)->get();
    return view("formations.ajouterParticipant", compact("formation","entreprises_retenues", "participants") );

  }
else{
    flash("Vous n'a pas l'autorisation d'effectuer cette action bien vouloir consulter l'administrateur")->error();
    return redirect()->back();
}
     
}
    //Fonction des Participants à une session de formation des AOP 
    public function selectionnerParticipantAlaSessionAOP(Formation $formation){
        if (Auth::user()->can('formation.modifier'))
        {
            //$entreprises_retenues = Entreprise::where("decision_du_comite_phase1", "retenu")->where('region', Auth::user()->zone)->orderBy('updated_at', 'desc')->get();
            //Recuperer la liste des entreprises déjà proprammées pour la formation
            $formation_programmees= ParticipantFormation::all();
            $id_entreprises=[];
            $i=0;
        if($formation_programmees != null){
        foreach($formation_programmees as $formation_programmee)
        {
            $id_entreprises[$i]= $formation_programmee->entreprise_id;
            $i++;
        }
    }
        // Recuperer la liste des entreprises rétenues pour la formation 
        $entreprises = Entreprise::where("decision_du_comite_phase1", "selectionnee")->where('entrepriseaop',1)->orderBy('updated_at', 'desc')->get();
        //dans liste des entreprises retenues exclure la liste des entreprises qui sont deja programmées pour une session
        $entreprises_retenues= $entreprises->except($id_entreprises);
        $participants = ParticipantFormation::where("formation_id", $formation->id)->get();
        return view("formations.ajouterParticipant", compact("formation","entreprises_retenues", "participants") );
        }
        return redirect()->back();
    }
    public function storeparticipant(Request $request)
    {
        $id_participants= $request->participants;
        $formation = $request->formation;
            foreach($id_participants as $participant){
                ParticipantFormation::create([
                "entreprise_id"=>$participant,
                "formation_id"=>$request->id_formation
            ]);
        }

    }
    public function supprimerparticipant(Request $request)
    {
        $id_participants= $request->participants;
        $formation = $request->id_formation;
        foreach($id_participants as $participant){
           $participant= ParticipantFormation::where('entreprise_id', $participant)->where('formation_id',$formation)->first();
           $participant->entreprise->update([
             "participer_a_la_formation"=>0,
           ]);
           $participant->delete();
    }
    }
    public function validerpresenceparticipant(Request $request){
        $id_participants= $request->participants;
        $formation = $request->id_formation;
        $participants= ParticipantFormation::whereIn('entreprise_id', $id_participants)->where('formation_id', $formation)->get();
        foreach($participants as $participant){
            $participant->update([
                "present"=>"oui",
        ]);
         $participant->entreprise->update([
            "participer_a_la_formation"=>1,
         ]);
    }
    }
    public function telechargerlalistedepresence(Formation $formation){
        if($formation->url_liste_presence){
            return $path = Storage::download($formation->url_liste_presence,"liste de présence".$formation->date_debut."au".$formation->date_fin.".pdf");
        }
        return redirect()->back();
    }
}
