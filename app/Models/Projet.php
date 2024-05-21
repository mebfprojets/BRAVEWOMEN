<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function investissements(){
        return $this->hasMany(InvestissementProjet::class);
    }
    public function investissementvalides(){
        return $this->hasMany(InvestissementProjet::class)->where('statut', 'valide');
    }
    public function entreprise(){
        return $this->belongsTo(Entreprise::class);
    }
   
    public function coach(){
        return $this->belongsTo(Coach::class, 'coach_id');
    }
    public function evaluations(){
        return $this->hasMany(EvaluationPca::class);
    }
    
    protected static function boot(){
        parent::boot();
        static::creating(function($projet){
            $projet->slug= 'PRJ'.$projet->entreprise_id.$projet->id;
  
        });
    }
       public function getRouteKeyName()
      {
          return 'slug';
      }

}
