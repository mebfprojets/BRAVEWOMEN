<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projetinfo extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function projet(){
        return $this->hasOne(Projet::class);
    }

}
