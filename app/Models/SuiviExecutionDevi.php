<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviExecutionDevi extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function devis(){
        return $this->belongsTo(Devi::class,'devi_id' );
    }
    public function images_de_suivis(){
        return $this->hasMany(ImageSuivi::class);
    }
}
