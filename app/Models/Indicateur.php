<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicateur extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function categorie(){
        return $this->belongsTo(Valeur::class,'categorie_id');
     }
    public function impacts(){
        return $this->hasMany(Impact::class);
    }

}
