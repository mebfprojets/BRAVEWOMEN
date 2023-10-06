<?php

namespace App\Http\Controllers;

use App\Models\SucessStorie;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

   public function get_success_storie(Request $request)
   {
            $success_storie= SucessStorie::find($request->id);
            $data= array('titre'=>$success_storie->apercu, 'description'=>$success_storie->description, 'beneficiaire'=>$success_storie->beneficaire->denomination);
            return json_encode($data);
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
