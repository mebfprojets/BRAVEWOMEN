<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;

class FinancementController extends Controller
{
    public function enregistre(){
        $entreprises= Entreprise::where("decision_du_comite_phase1", "retenu")->where("participer_a_la_formation", 1)->orderBy('updated_at', 'desc')->get();
        return view('financement.register', compact("entreprises"));
    }
}
