<?php

namespace App\Http\Controllers;

use App\Models\GrilleEval;
use Illuminate\Http\Request;

class GrilleEvalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $grilles= GrilleEval::all();
      return view('grilles.index', compact('grilles'));
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
        GrilleEval::create([
            'categorie'=> $request->categorie, 
            'libelle'=> $request->libelle, 
            'ponderation'=> $request->ponderation, 
        ]);
        return redirect()->route('grille.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GrilleEval  $grilleEval
     * @return \Illuminate\Http\Response
     */
    public function show(GrilleEval $grilleEval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GrilleEval  $grilleEval
     * @return \Illuminate\Http\Response
     */
    public function edit(GrilleEval $grilleEval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GrilleEval  $grilleEval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GrilleEval $grilleEval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GrilleEval  $grilleEval
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrilleEval $grilleEval)
    {
        //
    }
        public function modifier(Request $request){
        $grille= GrilleEval::find($request->id);
       // dd($grille);
        $data = array(
         'id'=>$grille->id,
         'libelle'=>$grille->libelle,
         'categorie'=> $grille->categorie, 
         'ponderation'=>$grille->ponderation,
     );
     return json_encode($data);
 }
 public function modifierstore(Request $request){
    $grille= GrilleEval::find($request->grille_id);
    $grille->update([
        'libelle'=> $request->libelle, 
        'categorie'=> $request->categorie, 
        'ponderation'=> $request->ponderation, 
]);
    return redirect()->route('grille.index');

 }
}
