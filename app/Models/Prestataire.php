<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestataire extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected static function boot(){
        parent::boot();
        static::creating(function($prestataire){
            $prestataire->slug= $prestataire->code_prestaire;
        });
    }
    public function prestations(){
        return $this->hasMany(Devi::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
