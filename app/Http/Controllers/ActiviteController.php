<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\SimpleExcel\SimpleExcelReader;

class ActiviteController extends Controller
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
        $activites= Activite::all();
       $date_deffet= Activite::first()->created_at;
       return view('activite.index', compact('activites','date_deffet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activites= Activite::all();
        return view('activite.create', compact('activites')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date_debut= date('Y-m-d', strtotime($request->date_de_debut));
        $date_de_fin= date('Y-m-d', strtotime($request->date_de_fin));
        Activite::create([
            'libelle'=>$request->libelle_activite, 
            'taux_de_realisation'=>$request->taux_de_realisation, 
            'date_debut'=>$date_debut, 
            'activite_id'=>$request->activite_principale, 
            'date_fin'=> $date_de_fin,
        ]);
        flash("Activité créee avec success !!!")->success();
        return redirect()->route('activites.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function show(Activite $activite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function edit(Activite $activite)
    {
        $activites= Activite::all();
        return view('activite.update', compact('activite', 'activites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activite $activite)
    {
        $date_debut= date('Y-m-d', strtotime($request->date_de_debut));
        $date_de_fin= date('Y-m-d', strtotime($request->date_de_fin));
        $activite->update([
            'libelle'=>$request->libelle_activite, 
            'taux_de_realisation'=>$request->taux_de_realisation, 
            'date_debut'=>$date_debut, 
            'activite_id'=>$request->activite_principale, 
            'date_fin'=> $date_de_fin,
        ]);
        flash("Activité modifiée avec success !!!")->success();
        return redirect()->route("activites.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activite  $activite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activite $activite)
    {
        //
    }
    public function liste_activite(){
        $activites= Activite::all();
        $date_deffet= Activite::first()->created_at;
        $nombre_activite=  $activites->count();
        $taux_de_realisation_global= $activites->sum('taux_de_realisation')/$nombre_activite;
       $taux_de_realisation_global= number_format($taux_de_realisation_global, 2, '.', '');
        return view('activite.liste_dashbord',compact('activites', 'taux_de_realisation_global','date_deffet'));
    }
    public function activity_all(){
        $activites= Activite::all();
        if($activites){
         foreach( $activites as $value)
         {
            $activite_json[] = array('id'=>$value->id,'libelle'=>$value->libelle, 'date_debut'=>$value->date_debut, 'date_fin'=>$value->date_fin, 'taux'=>$value->taux_de_realisation, 'numero'=>$value->numero);
         }
         return json_encode($activite_json);
     }
      else 
      return $activite_json=0;
         
     }
    public function liste_activity(){
        $activites= Activite::all();

        $table = array();

        $table['cols'] = array(
    
                               array('type' => 'string', 'label' => 'Libelle'),
                               array('type' => 'string', 'label' => 'name'),
                               array('type' => 'date', 'label' => 'Date_debut'),
                               array('type' => 'date', 'label' => 'Date_fin'));
    if($activites){
        foreach( $activites as $r)
            {
                $month_debut = date('m',strtotime($r['date_debut']));
                $val_debut=(integer)$month_debut -1;
                $month_fin = date('m',strtotime($r['date_fin']));
                $val_fin= (integer)$month_fin -  1;
                $temp = array();
                $temp[] = array('v' => $r['libelle']);
                $temp[] = array('v' => $r['libelle']);
                $temp[] = array('v' => 'Date('.date('Y',strtotime($r['date_debut'])).','. $val_debut .','.date('d',strtotime($r['date_debut'])).')');
                $temp[] = array('v' => 'Date('.date('Y',strtotime($r['date_fin'])).','.$val_fin.','.date('d',strtotime($r['date_fin'])).')');
                $rows[] = array('c' => $temp);
            }
           
        }
        else{
            $rows[]=[];
        }
            $table['rows'] = $rows;
            $jsonTable = json_encode($table);
            return $jsonTable;
    }
    public function return_view_import(){
        return view('activite.import');
    }

    public function chargerActivite(Request $request){
        // 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
        $this->validate($request, [
            'fichier' => 'bail|required|file|mimes:xlsx'
        ]);
    
        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    
        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);
         // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();

    //vider la table activité 

        Activite::truncate();
    $ids=[];
    $i=0;
    foreach($rows as $row){
        $datas[]= array('numero'=>$row['numero'],'activite'=>$row['activite'], 'numero_precedent'=>$row['numero_precedent'], 'date_debut'=>$row['date_debut'],'date_fin'=>$row['date_fin'],'taux_de_realisation'=>$row['taux_de_realisation']);
    }
            foreach($datas as $data){
                    Activite::create([
                        'numero'=>$data['numero'],
                        'libelle'=>$data['activite'],
                        'numero_precedent'=>$data['numero_precedent'],
                        'date_debut'=>$data['date_debut'],
                        'date_fin'=>$data['date_fin'],
                        'taux_de_realisation'=>$data['taux_de_realisation'],
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
}
