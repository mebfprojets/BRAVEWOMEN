<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationPca extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function critere(){
        return $this->belongsTo(GrilleEval::class, 'grilleeval_id');
    }
}
