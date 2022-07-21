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
    public function investissements(){
       return $this->hasMany(Investissement::class);
    }
    public function infoentreprises(){
        return $this->hasMany(Infoentreprise::class);
    }
    public function Infoeffectifs(){
        return $this->hasMany(Infoeffectifentreprise::class);
    }

    // public function projet(){
    //     return $this->hasOne(Projet::class,'entreprise_id');
    // }
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


}
