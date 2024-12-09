<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory,HasUlids;
    protected $fillable = ['uuid', 'user_id','libelle','action'];

     /***
        * User creator typeMatieres
        */

        public function users(){
            return $this->hasMany('App\Models\User','user_id','id');
          }
  
       
}
