<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function piecejointes(){
        return $this->hasMany(Piecejointe::class, 'entreprise_id');
    }
    public function devis_valides(){
        return $this->hasMany(Devi::class)->where('statut', 'validé');
    }
    public function investissements(){
       return $this->hasMany(Investissement::class);
    }
    public function infoentreprises(){
        return $this->hasMany(Infoentreprise::class);
    }
    public function Infoeffectifs(){
        return $this->hasMany(Infoeffectifentreprise::class);
    }
   
  public function chiffredaffaires(){
        return $this->hasMany(Infoentreprise::class)->where('indicateur',42);
    }
    public function devis(){
        return $this->hasMany(Devi::class);
    }
    public function factures(){
        return $this->hasMany(Facture::class);
    }

    public function projet(){
        return $this->hasOne(Projet::class);
     }
     public function promotrice(){
        return $this->belongsTo(Promotrice::class);
     }
     public function decisions(){
         return $this->hasMany(Decision::class);
     }
     public function evaluations(){
        return $this->hasMany(Evaluation::class);
     }
     public function formations(){
         return $this->belongsToMany(Formation::class);
     }
     public function banque(){
        return $this->belongsTo(Banque::class);
    }
    public function accomptes(){
        return $this->hasMany(Accompte::class);
    }
    public function subventions(){
        return $this->hasMany(Subvention::class);
    }
    public function activites_horizontales_menees(){
        return $this->hasMany(Entreprise_activite::class)->where("type","horizontale");
    }
    public function activites_horizontales_invests(){
        return $this->hasMany(Entreprise_activite_invest::class)->where("type","horizontale");
    }
    public function activites_verticales_menees(){
        return $this->hasMany(Entreprise_activite::class)->where("type","verticale");
    }
    public function activites_verticales_invests(){
        return $this->hasMany(Entreprise_activite_invest::class)->where("type","verticale");
    }
    public function acquisitions (){
        return $this->hasMany(Acquisition::class);
    }
    public function acquisitions_valides (){
        return $this->hasMany(Acquisition::class)->where("acquis",1);
    }


}
