<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucessStorie extends Model
{
    use HasFactory;
    public $table= "success_stories";
    protected $guarded=[];
    public function beneficaire(){
        return $this->belongsTo(Entreprise::class,'entreprise_id' );
    }
}
