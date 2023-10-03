<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function prestataire(){
        return $this->belongsTo(Prestataire::class);
     }
    public function entreprise(){
        return $this->belongsTo(Entreprise::class);
     }
     public function factures(){
        return $this->hasMany(Facture::class);
     }
     public function factures_soumis(){
      return $this->hasMany(Facture::class)->where('statut', 'soumis');
     }
     public function factures_en_cours(){
        return $this->hasMany(Facture::class)->where('statut', '!=' , 'payee');
       }
     public function factures_payees(){
      return $this->hasMany(Facture::class)->where('statut', 'payee');
     }
    
     public function historiques(){
         return $this->hasMany(Historiquedevi::class,'devis_id');
     }
     public function suiviExecution(){
        return $this->hasMany(SuiviExecutionDevi::class);
    }
     public function ligneinvestissement(){
        return $this->belongsTo(InvestissementProjet::class, 'investissement_projets_id');
     }
     protected static function boot(){
      parent::boot();
      static::creating(function($devi){
          $devi->slug= $devi->numero_devis.$devi->entreprise_id;

      });
  }
     public function getRouteKeyName()
    {
        return 'slug';
    }
     public function sluggable(): array
     {
         return [
             'slug' => [
                 'source' => 'numero_devis'.'devi_id'
             ]
         ];
     }
    
}
