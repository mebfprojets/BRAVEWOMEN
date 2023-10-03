<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historiquedevi extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function devi(){
        return $this->belongsTo(Devi::class,'devis_id');
     }
}
