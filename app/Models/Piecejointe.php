<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Piecejointe extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function promotrice(){
        return $this->belongsTo(Promotrice::class);
    }
    public function Entreprise(){
        return $this->belongsTo(Entreprise::class);
    }
}
