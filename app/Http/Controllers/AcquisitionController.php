<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class AcquisitionController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('acquisition.import');
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

    //vider la table activité 
    $ids=[];
    $i=0;
    foreach($rows as $row){
        $datas[]= array('code_promoteur'=>$row['code_promoteur'],'categorie_invest'=>$row['categorie'],'designation'=>$row['designation'], 'description'=>$row['description'], 'quantite'=>$row['quantite'], 'cout_unitaire'=>$row['cout_unitaire'],'cout_total'=>$row['cout_total']);
    }
    //Supprimer les anciennes données avant l'import 
    foreach($datas as $data){

        $entreprise=Entreprise::where('code_promoteur', $data['code_promoteur'])->where('date_de_signature_accord_beneficiaire','!=',null)->first();
      //  dd($entreprise);
        Acquisition::where('entreprise_id',$entreprise->id)->delete();
    }
        foreach($datas as $data){
            //traitement de la categorie d'investissment
            if($data['categorie_invest']=='Construction'){
                $categorie= 7124;
            }
            elseif($data['categorie_invest']=='Aménagement'){
                $categorie= 7125;
            }
            elseif($data['categorie_invest']=='Matériel technique'){
                $categorie= 7126;
            }
            elseif($data['categorie_invest']=='Matériel informatique'){
                $categorie= 7127;
            }
            elseif($data['categorie_invest']=='Mobilier et matériel de bureau'){
                $categorie= 7128;
            }
            elseif($data['categorie_invest']=='Matériel roulant'){
                $categorie= 7129;
            }
            elseif($data['categorie_invest']=='Réalisation hydraulique'){
                $categorie= 7132;
            }
                $entreprise=Entreprise::where('code_promoteur', $data['code_promoteur'])->first();
                    Acquisition::create([
                        'entreprise_id'=> $entreprise->id,
                        'designation'=>$data['designation'],
                        'description'=>$data['description'],
                        'categorie_invest'=>$categorie,
                        'quantite'=>$data['quantite'],
                        'cout_unitaire'=>$data['cout_unitaire'],
                        'cout_total'=>$data['cout_total'],
                        'acquis'=>0,
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
public function par_entreprise(Entreprise $entreprise){
       ($entreprise->aopOuleader==1)?($type_entreprise='pca_aop'):($type_entreprise='pca_mpme');
        return view("acquisition.lister", compact('entreprise','type_entreprise'));
}
public function valider_acquisition(Request $request){
    $acquisition= Acquisition::find($request->id);
    if($request->cocher=='true'){
        $acquisition->update([
            'acquis'=>1
           ]);
           return 0;
    }
    elseif($request->cocher=='false'){
        $acquisition->update([
            'acquis'=>0
           ]);
           return 0;
    }
          
   
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acquisition  $acquisition
     * @return \Illuminate\Http\Response
     */
    public function show(Acquisition $acquisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acquisition  $acquisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Acquisition $acquisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acquisition  $acquisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acquisition $acquisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acquisition  $acquisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acquisition $acquisition)
    {
        //
    }
}
