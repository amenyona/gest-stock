<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'montantTotal',
        'natureReglement',
        'preuve',
        'worked'
    ];

    
      public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
     }
  
}
