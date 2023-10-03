<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function devi(){
        return $this->belongsTo(Devi::class);
     }
     public function entreprise(){
        return $this->belongsTo(Entreprise::class);
     }
     public function historiques(){
        return $this->hasMany(Historiquefacture::class,'facture_id');
    }
    public function historique_payee(){
        return $this->hasOne(Historiquefacture::class,'facture_id')->where('statut', 'payée');
    }
    public function historique_validee(){
        return $this->hasOne(Historiquefacture::class,'facture_id')->where('statut', 'validé');
    }
    public function images_des_biens(){
        return $this->hasMany(FactureImage::class);
    }
    
    protected static function boot(){
        parent::boot();
        static::creating(function($facture){
            $facture->slug= $facture->num_facture.$facture->devi->entreprise_id;
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
                 'source' => 'num_facture'.'devi_id'
             ]
         ];
     }
}
