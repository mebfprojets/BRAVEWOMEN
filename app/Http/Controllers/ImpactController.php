<?php

namespace App\Http\Controllers;

use App\Models\Impact;
use App\Models\Valeur;
use App\Models\Indicateur;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImpactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function liste_indicateur(){
        $categories=Valeur::where('parametre_id',40)->get();
        $unites=Valeur::where('parametre_id',41)->get();
        $indicateurs= Indicateur::all();
        return view('indicateur.liste', compact('indicateurs','categories','unites'));
    }
    public function store_indicateur(Request $request){
        Indicateur::create([
            'code_indicateur'=> $request->code,
            'libelle'=> $request->libelle,
            'categorie_id' => $request->categorie,
            'unite' => $request->unite,
            'cible' => $request->cible,

        ]);
        return redirect()->route('indicateur.index');
    }
    public function modifier(Request $request) {
        $indicateur= Indicateur::find($request->id);
        $data = array(
         'id'=>$indicateur->id,
         'libelle'=>$indicateur->libelle,
         'categorie'=> $indicateur->categorie_id, 
         'unite'=> $indicateur->unite,
         'cible'=> $indicateur->cible,
         'code_indicateur'=>$indicateur->code_indicateur,
     );
     return json_encode($data);
    }
    public function updateImpact(Request $request){
            $impact = Impact::find($request->impact_id);
            //dd($request->all());
            $impact->update([
                'indicateur_id'=>$request->indicateur,
                'valeur_ref'=>$request->valeur_ref,
                'valeur_resultat'=>$request->valeur_resultat,
                'valeur_creee'=>$request->valeur_resultat - $request->valeur_ref,

            ]);
            flash("Modification éffectuée avec success")->success();
            return redirect()->back();
    }
    public function modifier_impact(Request $request) {
        $impact= Impact::find($request->id);
        $data = array(
         'id'=>$impact->id,
         'entreprise_id'=>$impact->entreprise_id,
         'indicateur_id'=> $impact->indicateur_id, 
         'valeur_ref'=> $impact->valeur_ref,
         'valeur_resultat'=> $impact->valeur_resultat,
     );
       return json_encode($data);
    }
   
    public function update_indicateur(Request $request){
    $indicateur= Indicateur::find($request->indicateur_id);
    $indicateur->update([
        'libelle'=> $request->libelle, 
        'categorie_id'=> $request->categorie, 
        'unite'=> $request->unite,
        'cible'=> $request->cible_u,
        'code_indicateur'=> $request->code_indicateur,
    ]);
      return redirect()->route('indicateur.index');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indicateurs=Indicateur::all();
        $impacts = Impact::all();
        return view('impact.liste', compact('impacts','indicateurs'));
    }
   
    public function dashboard_impact(){
        $nombre_demploi_crees= Impact::where('indicateur_id',env('IDINDICATEURNOMBREDEMPLOI'))->sum('valeur_creee');
        $acquisistions_valides_par_categories= DB::table('acquisitions')
                            ->leftjoin('valeurs','acquistions.categorie_invest','=','valeurs.id')
                            ->where('acquistions.acquis',1)
                            ->select("valeur.libelle as categorie","valeus.description as description", DB::raw("SUM(acquistions.cout_total) as montant"),DB::raw("count(acquisitions.id) as nombre"))
                            ->groupBy('categorie.id')
                            ->get();
        return view('dashboard.detail_impact',compact('acquisistions_valides_par_categories','nombre_demploi_crees','nombre_de_nouveaux_clients'));
    }
public function beneficiaires_ayant_cree_emplois(Request $request)
{
        $beneficiaire_ayant_cree_emplois= DB::table('impacts')
                        ->join('entreprises',function($join){
                            $join->on('impacts.entreprise_id','=','entreprises.id')
                            ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH'),env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH')]);
                        })
                        ->where('impacts.valeur_creee','>',0)
                        ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                        ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                        ->select("valeurs.libelle as secteur_dactivite", DB::raw("count(distinct(entreprises.id)) as nombre"))
                        ->get();
        $beneficiaire_nayant_pas_cree_demploi= DB::table('impacts')
                        ->join('entreprises',function($join){
                            $join->on('impacts.entreprise_id','=','entreprises.id')
                            ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH'),env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH')]);
                        })
                        ->where('impacts.valeur_creee',0)
                        ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                        ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                        ->select("valeurs.libelle as secteur_dactivite", DB::raw("count(distinct(entreprises.id)) as nombre"))
                        ->get();
                       //dd(json_encode(array($beneficiaire_ayant_cree_emplois,$beneficiaire_nayant_pas_cree_demploi)));
             return json_encode(array($beneficiaire_ayant_cree_emplois,$beneficiaire_nayant_pas_cree_demploi));
            
}


    public function emploi_par_secteurdactivite(Request $request){
        $categorie_entreprise= $request->categorie;
        if($categorie_entreprise=='all'){
            $emploi_cree_par_secteurdactivites_temporaire= DB::table('entreprises')
                                                    ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH')]);
                                                    })
                                                    ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                                    ->select("valeurs.libelle as secteur_dactivite", DB::raw("sum(impacts.valeur_creee) as nombre"))
                                                    ->get(); 
            $emploi_cree_par_secteurdactivites_permanent= DB::table('entreprises')
                                                    ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH')]);
                                                    })
                                                    ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                                    ->select("valeurs.libelle as secteur_dactivite", DB::raw("sum(impacts.valeur_creee) as nombre"))
                                                    ->get();                          
            }
          elseif($categorie_entreprise=='mpme'){
            $emploi_cree_par_secteurdactivites_temporaire= DB::table('entreprises')
                                                    ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->where('entreprises.aopOuleader','=','mpme')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH'),]);
                                                    })
                                                    ->leftjoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                                    ->select("valeurs.libelle as secteur_dactivite", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                                    ->get();
            $emploi_cree_par_secteurdactivites_permanent= DB::table('entreprises')
                                                        ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->where('entreprises.aopOuleader','=','mpme')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH')]);
                                                    })
                                                    ->leftjoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                                    ->select("valeurs.libelle as secteur_dactivite", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                                    ->get();
        }
        else{
            $emploi_cree_par_secteurdactivites_temporaire= DB::table('entreprises')
                                                       ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH'),])
                                                        ->whereIn('entreprises.aopOuleader',['aop','leader']);
                                                    })
                                                    ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                                    ->select("valeurs.libelle as secteur_dactivite", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                                    ->get();
                $emploi_cree_par_secteurdactivites_permanent= DB::table('entreprises')
                                                    ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH')])
                                                        ->whereIn('entreprises.aopOuleader',['aop','leader']);
                                                    })
                                                    ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle'  )
                                                    ->select("valeurs.libelle as secteur_dactivite", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                                    ->get();
        }
       
               return json_encode(array($emploi_cree_par_secteurdactivites_permanent,$emploi_cree_par_secteurdactivites_temporaire));
    }
    public function emploi_par_zone(Request $request){
        $categorie_entreprise= $request->categorie;
        if($categorie_entreprise=='all'){
            $emploi_cree_par_zone_temporaire= DB::table('entreprises')
                                            ->join('impacts',function($join){
                                                $join->on('impacts.entreprise_id','=','entreprises.id')
                                                ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH'),]);
                                            })
                                            ->leftjoin('valeurs','valeurs.id','=','entreprises.region')
                                            ->groupBy('entreprises.region', 'valeurs.libelle')
                                            ->select("valeurs.libelle as zone", DB::raw("sum(impacts.valeur_creee) as nombre"))
                                            ->get();
        $emploi_cree_par_zone_permanent= DB::table('entreprises')
                                            ->join('impacts',function($join){
                                                $join->on('impacts.entreprise_id','=','entreprises.id')
                                                ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH')]);
                                            })
                                            ->leftjoin('valeurs','valeurs.id','=','entreprises.region')
                                            ->groupBy('entreprises.region', 'valeurs.libelle')
                                            ->select("valeurs.libelle as zone", DB::raw("sum(impacts.valeur_creee) as nombre"))
                                            ->get();
            }
        elseif($categorie_entreprise=='mpme'){
            $emploi_cree_par_zone_temporaire= DB::table('entreprises')
                                        ->join('impacts',function($join){
                                            $join->on('impacts.entreprise_id','=','entreprises.id')
                                            ->where('entreprises.aopOuleader','=','mpme')
                                            ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH'),]);
                                        })
                                        ->leftjoin('valeurs','valeurs.id','=','entreprises.region')
                                        ->groupBy('entreprises.region', 'valeurs.libelle')
                                        ->select("valeurs.libelle as zone", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                        ->get();
            $emploi_cree_par_zone_permanent= DB::table('entreprises')
                                        ->join('impacts',function($join){
                                            $join->on('impacts.entreprise_id','=','entreprises.id')
                                            ->where('entreprises.aopOuleader','=','mpme')
                                            ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH'),]);
                                        })
                                        ->leftjoin('valeurs','valeurs.id','=','entreprises.region')
                                        ->groupBy('entreprises.region', 'valeurs.libelle')
                                        ->select("valeurs.libelle as zone", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                        ->get();
        }
        else{
            $emploi_cree_par_zone_temporaire= DB::table('entreprises')
                                                    ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPTF'),env('INDICATEURNBREEMPTH'),])
                                                        ->whereIn('entreprises.aopOuleader',['aop','leader']);
                                                    })
                                                    ->join('valeurs','valeurs.id','=','entreprises.region')
                                                    ->groupBy('entreprises.region', 'valeurs.libelle')
                                                    ->select("valeurs.libelle as zone", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                                    ->get();
            $emploi_cree_par_zone_permanent= DB::table('entreprises')
                                                    ->join('impacts',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ->whereIn('impacts.indicateur_id',[env('INDICATEURNBREEMPPF'),env('INDICATEURNBREEMPPH'),])
                                                        ->whereIn('entreprises.aopOuleader',['aop','leader']);
                                                    })
                                                    ->join('valeurs','valeurs.id','=','entreprises.region')
                                                    ->groupBy('entreprises.region', 'valeurs.libelle')
                                                    ->select("valeurs.libelle as zone", DB::raw("SUM(impacts.valeur_creee) as nombre"))
                                                    ->get();
        }
           // dd($emploi_cree_par_zone_permanent);
               return json_encode(array($emploi_cree_par_zone_permanent, $emploi_cree_par_zone_temporaire));
    }
    public function indicateur_par_secteurdactivite(Request $request){
        $categorie_entreprise= $request->categorie;
       // dd($categorie_entreprise);
        $indicateur_code= $request->indicateur;
        $indicateur= Indicateur::where('code_indicateur',$indicateur_code)->first()->id;
        $indicateur_stable_secteurdactivites= DB::table('impacts')
            ->leftjoin('entreprises',function($join){
                $join->on('impacts.entreprise_id','=','entreprises.id');
            })
            ->where('impacts.valeur_creee','<',1)
            ->where('impacts.indicateur_id','=',$indicateur)
            ->join('valeurs','valeurs.id','=','entreprises.secteur_activite')
            ->groupBy('entreprises.secteur_activite','valeurs.libelle','entreprises.aopOuleader'  )
            ->select("valeurs.libelle as secteur_dactivite","entreprises.aopOuleader as categorie", DB::raw("count(impacts.entreprise_id) as nombre"))
            ->get();
        
        if($categorie_entreprise=='mpme'){
            $indicateur_stable_secteurdactivites= $indicateur_stable_secteurdactivites->where('categorie','mpme');
        }
        elseif($categorie_entreprise=='aopouleader'){
            $indicateur_stable_secteurdactivites= $indicateur_stable_secteurdactivites->whereIn('categorie',['aop','leader']);
        }
        else{
            $indicateur_stable_secteurdactivites= $indicateur_stable_secteurdactivites;
        }
    
    $indicateur_a_evoluer_secteurdactivites= DB::table('impacts')
                                                    ->leftjoin('entreprises',function($join){
                                                        $join->on('impacts.entreprise_id','=','entreprises.id')
                                                        ;
                                                    })
                                                    ->where('impacts.valeur_creee','>',0)
                                                    ->where('impacts.indicateur_id','=',$indicateur)
                                                    ->leftJoin('valeurs','valeurs.id','=','entreprises.secteur_activite')
                                                    ->groupBy('entreprises.secteur_activite','valeurs.libelle','entreprises.aopOuleader')
                                                    ->select("valeurs.libelle as secteur_dactivite","entreprises.aopOuleader as categorie", DB::raw("count(impacts.entreprise_id) as nombre"))
                                                    ->get();
                                    //dd($indicateur_a_evoluer_secteurdactivites);
                                        if($categorie_entreprise=='mpme'){
                                            $indicateur_a_evoluer_secteurdactivites= $indicateur_a_evoluer_secteurdactivites->where('categorie','mpme');
                                         }
                                         elseif($categorie_entreprise=='aopouleader'){
                                             $indicateur_a_evoluer_secteurdactivites= $indicateur_a_evoluer_secteurdactivites->whereIn('categorie',['aop','leader']);
                                         }
                                         else{
                                             $indicateur_a_evoluer_secteurdactivites= $indicateur_a_evoluer_secteurdactivites;
                                        }  
                                     // dd($indicateur_code);    
                                 return json_encode(array($indicateur_a_evoluer_secteurdactivites,$indicateur_stable_secteurdactivites));
               
    }
public function indicateur_par_zone(Request $request){
        $categorie_entreprise= $request->categorie;
        $indicateur_code= $request->indicateur;
        $indicateur= Indicateur::where('code_indicateur',$indicateur_code)->first()->id;
        $indicateur_stable_zone= DB::table('impacts')
        ->leftjoin('entreprises',function($join){
            $join->on('impacts.entreprise_id','=','entreprises.id');
        })
        ->where('impacts.valeur_creee','=',0)
        ->where('impacts.indicateur_id','=',$indicateur)
        ->join('valeurs','valeurs.id','=','entreprises.region')
        ->groupBy('entreprises.region', 'valeurs.libelle','entreprises.aopOuleader')
        ->select("valeurs.libelle as zone","entreprises.aopOuleader as categorie", DB::raw("count(impacts.entreprise_id) as nombre"))
        ->get();
    //Filtrer par categorie d'entreprise
    if($categorie_entreprise=='mpme'){
        $indicateur_stable_zone= $indicateur_stable_zone->where('categorie','mpme');
    }
    elseif($categorie_entreprise=='aopouleader'){
        $indicateur_stable_zone= $indicateur_stable_zone->whereIn('categorie',['aop','leader']);
    }
    else{
        $indicateur_stable_zone= $indicateur_stable_zone;
    }
    $indicateur_a_evoluer_zone= DB::table('impacts')
        ->leftjoin('entreprises',function($join){
            $join->on('impacts.entreprise_id','=','entreprises.id')
            ;
        })
        ->where('impacts.valeur_creee','>',0)
        ->where('impacts.indicateur_id','=',$indicateur)
        ->leftJoin('valeurs','valeurs.id','=','entreprises.region')
        ->groupBy('entreprises.region', 'valeurs.libelle','entreprises.aopOuleader')
        ->select("valeurs.libelle as zone","entreprises.aopOuleader as categorie", DB::raw("count(impacts.entreprise_id) as nombre"))
        ->get();
        if($categorie_entreprise=='mpme'){
           $indicateur_a_evoluer_zone= $indicateur_a_evoluer_zone->where('categorie','mpme');
        }
        elseif($categorie_entreprise=='aopouleader'){
           $indicateur_a_evoluer_zone= $indicateur_a_evoluer_zone->whereIn('categorie',['aop','leader']);
        }
        else{
          $indicateur_a_evoluer_zone= $indicateur_a_evoluer_zone;
        } 
    return json_encode(array($indicateur_a_evoluer_zone,$indicateur_stable_zone));
}
    public function newclient_par_secteurdactivite(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fichier' => 'bail|required|file|mimes:xlsx'
        ]);
    
        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    
        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);
         // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();
    $ids=[];
    $i=0;
    foreach($rows as $row){
        $datas[]= array('date_collecte'=>$row['date_collecte'],'code_promotrice'=>$row['code_promotrice'],'code_indicateur'=>$row['code_indicateur'], 'valeur_ref'=>$row['valeur_ref'], 'valeur_resultat'=>$row['valeur_resultat']);
    }
            foreach($datas as $data){
                $date_collecte= $data['date_collecte']->format('Y-m-d');
                $indicateur= Indicateur::where('code_indicateur', $data['code_indicateur'])->first();
                $entreprise= Entreprise::where('code_promoteur', $data['code_promotrice'])->first();
                if($entreprise){
                    $impact_existe= Impact::where('entreprise_id', $entreprise->id)->where('date_collecte', $date_collecte )->where('indicateur_id', $indicateur->id )->delete();
                    Impact::create([
                        'date_collecte'=>$date_collecte,
                        'indicateur_id'=>$indicateur->id,
                        'entreprise_id'=>$entreprise->id,
                        'valeur_ref'=>$data['valeur_ref'],
                        'valeur_resultat'=>$data['valeur_resultat'],
                        'valeur_creee'=>$data['valeur_resultat'] - $data['valeur_ref'],
                    ]);
                }
                
                    
                
        }
        // $rows est une Illuminate\Support\LazyCollection
    
        // 4. On insère toutes les lignes dans la base de données
        
        $status = TRUE;
    
        // Si toutes les lignes sont insérées
        if ($status) {
    
            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
            
            flash("Import effectué avec success")->success();
            return back()->withMsg("Importation réussie !");
        } else { abort(500); }
    }

    public function import_ref(Request $request)
    {
        $this->validate($request, [
            'fichier' => 'bail|required|file|mimes:xlsx'
        ]);
    
        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);
         // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();
        $ids=[];
        $i=0;
    foreach($rows as $row){
        $datas[]= array('date_collecte'=>$row['date_collecte'],'code_promotrice'=>$row['code_promotrice'],'EMPPH'=>$row['EMPPH'] ,'EMPPF'=>$row['EMPPF'] ,'EMPTF'=>$row['EMPTF'],'EMPTH'=>$row['EMPTH'],'CA'=>$row['CA'],'NCLT'=>$row['NCLT'],'BENEF'=>$row['BENEF'],'SALM'=>$row['SALM']);
    }
            foreach($datas as $data){
                $date_collecte= $data['date_collecte']->format('Y-m-d');
                $ind_empph= Indicateur::where('code_indicateur', $data['EMPPH'])->first();
                $ind_emppf= Indicateur::where('code_indicateur', $data['EMPPF'])->first();
                $ind_emptf= Indicateur::where('code_indicateur', $data['EMPTF'])->first();
                $ind_empth= Indicateur::where('code_indicateur', $data['EMPTH'])->first();
                $ind_ca= Indicateur::where('code_indicateur', $data['CA'])->first();
                $ind_nclt= Indicateur::where('code_indicateur', $data['NCLT'])->first();
                $ind_benef= Indicateur::where('code_indicateur', $data['BENEF'])->first();
                $ind_salm= Indicateur::where('code_indicateur', $data['SALM'])->first();

                $entreprise= Entreprise::where('code_promoteur', $data['code_promotrice'])->where('date_de_signature_accord_beneficiaire','!=',null)->first();
                $impact_existe= Impact::where('entreprise_id', $entreprise->id)->where('date_collecte', $date_collecte )->where('indicateur_id', $indicateur->id )->delete();
                    Impact::create([
                        'date_collecte'=>$date_collecte,
                        'indicateur_id'=>$indicateur->id,
                        'entreprise_id'=>$entreprise->id,
                        'valeur'=>$data['valeur'],
                    ]);
                
        }
        // $rows est une Illuminate\Support\LazyCollection
    
        // 4. On insère toutes les lignes dans la base de données
        
        $status = TRUE;
    
        // Si toutes les lignes sont insérées
        if ($status) {
    
            // 5. On supprime le fichier uploadé
            $reader->close(); // On ferme le $reader
            
            flash("Import effectué avec success")->success();
            return back()->withMsg("Importation réussie !");
        } else { abort(500); }
    }

   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Impact  $impact
     * @return \Illuminate\Http\Response
     */
    public function show(Impact $impact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Impact  $impact
     * @return \Illuminate\Http\Response
     */
    public function edit(Impact $impact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Impact  $impact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Impact $impact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Impact  $impact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Impact $impact)
    {
        //
    }
}
