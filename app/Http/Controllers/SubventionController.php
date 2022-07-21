<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use App\Models\Subvention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
       // dd($accomptes);
        return view("subvention.index", compact("subventions","entreprise"));
    }
    public function create_for_beneficiary(Entreprise $entreprise)
    {
        return view("accompte.create", compact("entreprise") );
    }
    public function valider_montant(Request $request){
       $type_montant = $request->type_montant;
        $montant_subvention=reformater_montant($request->montant);
        $entreprise= Entreprise::find($request->id_entreprise);
    if($type_montant='subvention'){
        $total_subvention= $entreprise->subventions->sum('montant_subvention') + $montant_subvention;
        $total_accompte=$entreprise->accomptes->sum('montant');
       
        return ($total_subvention > $total_accompte) ? 2 : 0; 
       
    }
        
             
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('copie_du_recu')) {
            $copie_du_recu= $request->copie_du_recu->store('public/recu_subvention_beneficiaire');
        }
        else{
            $copie_du_recu=null;
        }
        // $montant= $request->montant;
       //dd($request->all());
           Subvention::create([
               'entreprise_id'=>$request['entreprise_id'],
               'date_subvention'=>$request['date'],
               'montant_subvention'=> reformater_montant($request->montant), 
               'copie_recu'=>$copie_du_recu
           ]);
           return redirect()->back();
    }
    public function get_recu(Subvention $subvention){
        // dd($accompt);
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
