<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSuivi extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function suivi(){
        return $this->belongsTo(SuiviExecutionDevi::class,'suivi_execution_devi_id');
    }
}
