<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
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
        $coachs= Coach::all();
        return view('coach.index', compact('coachs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('coach.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Coach::create([
            'nom' => $request->nom,
            'prenom'=> $request->prenom,
            'contact'=> $request->contact
        ]);
        return redirect()->route('coach.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function show(Coach $coach)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function edit(Coach $coach)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coach $coach)
    {
        $coach->update([
            'nom' => $request->nom,
            'prenom'=> $request->prenom,
            'contact'=> $request->contact
        ]);
        return redirect()->route('coach.index');
    }

    public function enremodif(Request $request)
    {
       // dd($request->coach);
        $coach= Coach::find($request->coach);
        $coach->update([
            'nom' => $request->nom,
            'prenom'=> $request->prenom,
            'contact'=> $request->contact
        ]);
        return redirect()->route('coach.index');
    }
    public function modif(Request $request){
        
        $coach= Coach::find($request->id);
        $data = array(
         'id'=>$coach->id,
         'nom'=>$coach->nom,
         'prenom'=>$coach->prenom,
         'contact'=>$coach->contact,
        
     );
     return json_encode($data);
 }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coach $coach)
    {
        //
    }
}
