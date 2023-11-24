<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DocumentController extends Controller
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
if(Auth::user()->can('document.view'))
{
        $documents= DB::table('documents')
        ->join('valeurs',function($join){
            $join->on('valeurs.id','=','documents.categorie');
        })
        ->groupBy('documents.categorie', "valeurs.libelle")
        ->select("documents.categorie as cat_id","valeurs.libelle as categorie", DB::raw("COUNT(documents.id) as nombre"))
        ->get();
        $categories= Valeur::where('parametre_id',43)->get();
        return view('document.index',compact("documents","categories"));
    }
    else{
        flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->success();
        return redirect()->back();
    }
    }
public function lister_document_par_categorie($id){
    if(Auth::user()->can('document.view'))
    {
        $categories= Valeur::where('parametre_id',43)->get();
        $documents=Document::where("categorie",$id)->get();
       return view('document.documentByCategorie',compact("categories","id","documents"));
    }
    else{
        flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->success();
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
    if(Auth::user()->can('document.create'))
        {
            $categories= Valeur::where('parametre_id',43)->get();
            return view('document.create',compact('categories'));
        }
        else{
            flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->error();
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
    if(Auth::user()->can('document.create'))
    {
        if($request->hasFile('document')) {
            $file = $request->file('document');
            $titre=$request->titre;
            $zone_user=(Auth::user()->zone==100)?"central":getlibelle(Auth::user()->zone);
            $categorie_doc= getlibelle($request->categorie);
            $extension=$file->getClientOriginalExtension();
            $fileName = $titre.'.'.$extension;
            $annee=date("Y");
            $emplacement='public/'.$categorie_doc.'/'.$annee.'/'.$zone_user; 
            $file_url= $request['document']->storeAs($emplacement, $fileName);
            Document::create([
                'categorie'=>$request->categorie,
                'titre_doc'=> $titre,
                'description_doc'=> $request->description,
                'url_doc'=> $file_url,
                'region_enregistrement'=>Auth::user()->zone,
                'creer_par' => Auth::user()->id,
                'modifier_par'=> Auth::user()->id,
            ]);
            flash("Le document enregistré avec success.")->success();
            return redirect()->route('document.index');
        }
        flash("Le document n'a pas été chargé.")->error();
        return redirect()->back();
    }
    else{
        flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->error();
        return redirect()->back();
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        if(Auth::user()->can('document.view'))
        {
       return view('document.afficher',compact('document'));
        }
        else{
            flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->error();
            return redirect()->back();
        }
        
    }
    public function afficher_document(Document $document)
    {
    if(Auth::user()->can('document.view'))
        {
            $categories= Valeur::where('parametre_id',43)->get();
            return view('document.afficher',compact('document','categories'));
        }
    else{
        flash("Vous n'avez pas le droit sur cette action. Bien vouloir contacter l'admnistrateur")->error();
        return redirect()->back();
    }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
    public function modif_document(Request $request){
                $document=Document::find($request->id);
                $test= array('id'=>$document->id, 'titre_doc'=>$document->titre_doc,'categorie'=>$document->categorie,'description'=>$document->description_doc,);
                 return json_encode($test);
    }
    public function modifier_document(Request $request){
        //dd($request->all());
        $document=Document::find($request->id_doc);
        $document->update([
            'titre_doc'=>$request->titre,
            'description_doc'=>$request->description,
            'categorie'=>$request->categorie,
        ]);
        if($request->hasFile('document')) {
            $file = $request->file('document');
            $titre=$request->titre;
            $zone_user=(Auth::user()->zone==100)?"central":getlibelle(Auth::user()->zone);
            $categorie_doc= getlibelle($request->categorie);
            $extension=$file->getClientOriginalExtension();
            $fileName = $titre.'.'.$extension;
            $annee=date("Y");
            $emplacement='public/'.$categorie_doc.'/'.$annee.'/'.$zone_user; 
            $file_url= $request['document']->storeAs($emplacement, $fileName);
            $document->update([
                'url_doc'=> $file_url
            ]);
        }
       return redirect()->route('documents.afficher',$document);
    }

}
