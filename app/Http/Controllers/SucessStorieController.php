<?php

namespace App\Http\Controllers;

use App\Models\SucessStorie;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class SucessStorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $success_stories= SucessStorie::all();
        $beneficaires = Entreprise::where('date_de_signature_accord_beneficiaire')->get();
        return view('success.index', compact('success_stories','beneficaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
    if(Auth::user()->can('creer_success_stories')){
        if($request->hasFile('image_successstorie')){
            $url_image_success_stories= $request->image_successstorie->store('public/success_stories_images');
        }
        SucessStorie::create([
                'apercu'=>$request['titre'],
                'entreprise_id'=>$request['beneficiaire'],
                'description'=>$request['description'],
                'created_by'=>Auth::user()->id,
                'url_image'=>$url_image_success_stories,
        ]);
        flash("Success stories enregistré avec success !!!")->success();
        return redirect()->back();
    }
        else{
            flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
            return redirect()->back();
        }
    }

   public function get_success_storie(Request $request)
   {
            $success_storie= SucessStorie::find($request->id);
            
            $array = preg_split('/[\/]/', $success_storie->url_image);
            $imagename= $array[2];
            $lien = 'storage/success_stories_images/'.$imagename;
            
            $data= array('id'=>$success_storie->id,'titre'=>$success_storie->apercu, 'description'=>$success_storie->description, 'beneficiaire'=>$success_storie->beneficaire->id,'url_img'=>$lien);
            return json_encode($data);
    }
    public function modifier_success_storie(Request $request){
    if(Auth::user()->can('update_success_stories')){
        $success_storie= SucessStorie::find($request->success_storie_id);
        if($request->hasFile('image_successstorie')){
            $url_image_success_stories= $request->image_successstorie->store('public/success_stories_images');
            $success_storie->update([
            'url_image'=>$url_image_success_stories,
        ]);

        }
            $success_storie->update([
            'apercu'=>$request['titre'],
            'entreprise_id'=>$request['beneficiaire'],
            'description'=>$request['description'],
            'created_by'=>Auth::user()->id,
        ]);
        return redirect()->back();
    }
    else{
        flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
        return redirect()->back();
    }
}
    public function supprimer_success_storie(Request $request){
        if(Auth::user()->can('update_success_stories')){
            $success_storie= SucessStorie::find($request->success_stories_id);
            $success_storie->delete();
            return redirect()->back();
        }
        else{
            flash("Vous n'avez pas ce droit. Bien vouloir contacter l'administrateur")->error();
            return redirect()->back();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SucessStorie  $sucessStorie
     * @return \Illuminate\Http\Response
     */
    public function show(SucessStorie $sucessStorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SucessStorie  $sucessStorie
     * @return \Illuminate\Http\Response
     */
    public function edit(SucessStorie $sucessStorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SucessStorie  $sucessStorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SucessStorie $sucessStorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SucessStorie  $sucessStorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(SucessStorie $sucessStorie)
    {
        //
    }
}
