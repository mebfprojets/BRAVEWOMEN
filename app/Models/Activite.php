<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function sous_activites(){
        return $this->hasMany(Activite::class);
    }
    public function activite(){
        return $this->belongsTo(Activite::class);
     }
}
