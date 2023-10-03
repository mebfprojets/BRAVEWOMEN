<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impact extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function indicateur(){
        return $this->belongsTo(indicateur::class,'indicateur_id');
     }
     public function entreprise(){
        return $this->belongsTo(entreprise::class,'entreprise_id');
     }
}
