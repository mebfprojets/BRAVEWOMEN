<?php

namespace App\Exports;

use App\Models\Entreprise;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EntrepriseExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('souscriptions.export', [
            'entreprises' =>Entreprise::all()
        ]);
        
    }
}
