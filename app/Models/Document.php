<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Document extends Model
{
    use HasFactory;

    protected $guarded=[];
    use HasFactory;
    protected static function boot(){
        parent::boot();
        static::creating(function($document){
            $document->slug= 'DOC'.Auth::user()->id.'_'.$document->categorie.'_'.uniqid();
        });
    }
       public function getRouteKeyName()
      {
          return 'slug';
      }
      public function auteur(){
        return $this->belongsTo(User::class,'creer_par');
     }

}
