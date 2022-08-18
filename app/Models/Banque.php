<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Entreprises(){
        return $this->hasMany(Entreprises::class);
    }
}
