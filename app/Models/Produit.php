<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'forme_id',
        'famille_id',
        'nom',
        'description',
        'prix',
        'quantiteStock',
        'dateExpiration',
        'quantiteSeuil',
        'image',
        'worked'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function fournisseurs(){
        return $this->belongsToMany('App\Models\Fournisseur');
      }

      public function forme(){
        return $this->belongsTo('App\Models\Forme','forme_id','id');
      }

      public function famille(){
        return $this->belongsTo('App\Models\Famille','famille_id','id');
      }
  

}
