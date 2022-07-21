<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotrice extends Model
{
    use HasFactory;
    use Sluggable;
    protected $guarded=[];
    public function piecejointes(){
        return $this->hasMany(Piecejointe::class, 'promotrice_id');
    }
    public function entreprises(){
        return $this->hasMany(Entreprise::class,'promotrice_id');
    }
    //changer la clé id par une autre dans le cas présent il sera remplacé par slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
     public function sluggable(): array
     {
         return [
             'slug' => [
                 'source' => 'code_promoteur'
             ]
         ];
     }
}
