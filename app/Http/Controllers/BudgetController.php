<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Cashflow;
use App\Models\PrevisionBudgetaire;  
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\DB;
class BudgetController extends Controller
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
        $budgets= Budget::all();          
        return view('budget.index',compact('budgets'));
    }
    public function return_view_import(){
        return view('budget.import');
    }

public function liste_budget(){
        $budgets= Budget::all();  
        //dd($budgets);
        $date_deffet= $budgets[0]->date_effet;
        $date = explode("-",$date_deffet);
        $mois = $date[1];
        $annee = $date[0];
        if($mois == '01' || $mois == '02' || $mois =='03'){
            $trimestre=1;
        }
            else if($mois == '04' || $mois == '05' || $mois =='06'){
                $trimestre=2;
            }
             else if($mois == '07' || $mois == '08' || $mois =='09'){
                $trimestre=3;
            }else{
                $trimestre=4;
            }
            $prevision_budgets= PrevisionBudgetaire::all();
            $previsiondate_deffet= $prevision_budgets[0]->date_effet;
            $pdate = explode("-",$previsiondate_deffet); 
            $prev_mois = $pdate[1];
            $prev_annee = $pdate[0];
            if($prev_mois == '01' || $prev_mois == '02' || $prev_mois =='03'){
                $ptrimestre=1;
            }
                else if($prev_mois == '04' || $prev_mois == '05' || $prev_mois =='06'){
                    $ptrimestre=2;
                }
                 else if($prev_mois == '07' || $prev_mois == '08' || $prev_mois =='09'){
                    $ptrimestre=3;
                }else{
                    $ptrimestre=4;
                }
             $date_deffet= $budgets[0]->date_effet;
        $date = explode("-",$date_deffet);
        $mois = $date[1];
        $annee = $date[0];
        if($mois == '01' || $mois == '02' || $mois =='03'){
            $trimestre=1;
        }
            else if($mois == '04' || $mois == '05' || $mois =='06'){
                $trimestre=2;
            }
             else if($mois == '07' || $mois == '08' || $mois =='09'){
                $trimestre=3;
            }else{
                $trimestre=4;
            }
        //$nombre_activite=  $activites->count(); 
        $cashflow_entres= Cashflow::where('categorie',1)->get();
        
        $cashflow_depenses= Cashflow::where('categorie',2)->get();   
        $date_deffet_cashf= $cashflow_depenses[0]->date_effet;
        $date_cashf = explode("-",$date_deffet_cashf);
        $mois_cashf = $date_cashf[1];
        $annee_cashf = $date_cashf[0];
        if($mois_cashf == '01' || $mois_cashf == '02' || $mois_cashf =='03'){
            $trimestre_cashf=1;
        }
            else if($mois_cashf == '04' || $mois_cashf == '05' || $mois_cashf =='06'){
                $trimestre_cashf=2;
            }
             else if($mois_cashf == '07' || $mois_cashf == '08' || $mois_cashf =='09'){
                $trimestre_cashf=3;
            }else{
                $trimestre_cashf=4;
            }
        //dd($cashflow_entres) ; 
        return view('budget.liste_dashbord',compact('cashflow_entres','cashflow_depenses','prevision_budgets','budgets','ptrimestre','trimestre', 'prev_mois','prev_annee','annee','trimestre_cashf','annee_cashf' ));
    }

    public function chargerBudget(Request $request){
        // 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
        $this->validate($request, [
            'fichier' => 'bail|required|file|mimes:xlsx'
        ]);
       
        $date_deffet= date('Y-m-d', strtotime($request->date_deffet));
        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    
        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);
         // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();
    //Supprimer l'ensemble des données de la table budget
        DB::table('budgets')->truncate();
    $ids=[];
    $i=0;
    foreach($rows as $row){
        $datas[]= array('composante'=>$row['composante'],
                        'montant_budgetise'=>$row['montant_budgetise'],
                        'cumul_depense_T_1'=>$row['cumul_depense_T_1'],
                        'depense_du_trimestre'=>$row['depense_du_trimestre'],
                        'solde_au_trimestre'=>$row['solde_au_trimestre']);
    }
            foreach($datas as $data){
                    Budget::create([
                        'composante'=>$data['composante'],
                        'montant_budgetise'=>$data['montant_budgetise'],
                        'cumul_depense_au_T_1'=>$data['cumul_depense_T_1'],
                        'depense_du_trimestre'=>$data['depense_du_trimestre'],
                        'solde_du_trimestre'=>$data['solde_au_trimestre'],
                        'date_effet'=>$date_deffet,
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
public function chargerPrevisionBudget(Request $request){
    
        // 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
        $this->validate($request, [
            'fichier' => 'bail|required|file|mimes:xlsx'
        ]);
       
        $date_deffet= date('Y-m-d', strtotime($request->date_deffet));
        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    
        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);
         // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();
    //Supprimer l'ensemble des données de la table budget
        DB::table('prevision_budgetaires')->truncate();
    $ids=[];
    $i=0;
    foreach($rows as $row){
        $datas[]= array('activite'=>$row['activite'],
                        'montant_depense'=>$row['montant_depense'],
                        'montant_budgetise'=>$row['montant_budgetise'],
                        'prevision_mois_n'=>$row['T0'],
                        'prevision_mois_n1'=>$row['T1'],
                        'prevision_mois_n2'=>$row['T2'],
                        'prevision_mois_n3'=>$row['T3']);
    }
            foreach($datas as $data){
                PrevisionBudgetaire::create([
                        'activite'=>$data['activite'],
                        'montant_budgetise'=>$data['montant_budgetise'],
                        'montant_depense'=>$data['montant_depense'],
                        'prevision_mois_n'=>$data['prevision_mois_n'],
                        'prevision_mois_n1'=>$data['prevision_mois_n1'],
                        'prevision_mois_n2'=>$data['prevision_mois_n2'],
                        'prevision_mois_n3'=>$data['prevision_mois_n3'],
                        'date_effet'=> $date_deffet
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
   
public function chargerCashflow(Request $request){
    
        // 1. Validation du fichier uploadé. Extension ".xlsx" autorisée
        $this->validate($request, [
            'fichier' => 'bail|required|file|mimes:xlsx'
        ]);
       
        $date_deffet= date('Y-m-d', strtotime($request->date_deffet));
        // 2. On déplace le fichier uploadé vers le dossier "public" pour le lire
        $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    
        // 3. $reader : L'instance Spatie\SimpleExcel\SimpleExcelReader
        $reader = SimpleExcelReader::create($fichier);
         // On récupère le contenu (les lignes) du fichier
        $rows = $reader->getRows();
    //Supprimer l'ensemble des données de la table budget
        DB::table('cashflows')->truncate();
    $ids=[];
    $i=0;
    foreach($rows as $row){
        $datas[]= array('libelle'=>$row['libelle'],
                        'categorie'=>$row['categorie'],
                        'T1'=>$row['T1'],
                        'T2'=>$row['T2'],
                        'T3'=>$row['T3'],
                        'T4'=>$row['T4']);


    }
            foreach($datas as $data){
                Cashflow::create([
                        'libelle'=>$data['libelle'],
                        'categorie'=>$data['categorie'],
                        'trimestre1'=>$data['T1'],
                        'trimestre2'=>$data['T2'],
                        'trimestre3'=>$data['T3'],
                        'trimestre4'=>$data['T4'],
                        'date_effet'=> $date_deffet
                    ]);
                
        }
    
    
        // $rows est une Illuminate\Support\LazyCollecion
    
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
