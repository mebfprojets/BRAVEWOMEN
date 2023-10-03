<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParametreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    if (Auth::user()->can('parametre.create')) {
        $parametres = Parametre::all();
        return view('parametres.index', compact('parametres'));
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    if (Auth::user()->can('parametre.create')) {
        $parametres = Parametre::all();
        return view('parametres.create', compact('parametres'));
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    if (Auth::user()->can('parametre.create')) {
        Parametre::create([
          'parametre_id'=>$request->parent,
           'libelle'=>$request->libele,
           'description'=>$request->description,
           ]);
           flash("Parametre enregistré avec succes!!!")->error();
           return redirect( route('parametres.index'));
        }
        else{
            flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function show(Parametre $parametre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function edit(Parametre $parametre)
    {
    if (Auth::user()->can('parametre.create')) {
        $params = Parametre::all();
        return view('parametres.edit', compact('parametre', 'params'));
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parametre $parametre)
    {
    if (Auth::user()->can('parametre.create')) {
        $parametre->libelle = $request->libelle;
        $parametre->description = $request->description;
        $parametre->parametre_id = $request->parent;
        $parametre->save();
        flash("Parametre modifié avec succes !!!")->success();
        return redirect(route('parametres.index'));
    }
    else{
        flash("Vous n'avez pas le droit d'acceder à cette resource. Veillez contacter l'administrateur!!!")->error();
        return redirect()->back();
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametre  $parametre
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Parametre::destroy($id);
        return redirect( route('parametres.index'));
    }
}
