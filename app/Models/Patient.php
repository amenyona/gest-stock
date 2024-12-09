<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'nom',
        'pernom',
        'telephone',
        'email',
        'worked'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user','id');
    }

    public function produits(){
        return $this->belongsToMany('App\Models\Produit', 'medecin_ordonnance_patient');
     }
 
    public function ordonnances(){
        return $this->belongsToMany('App\Models\Ordonnance', 'medecin_ordonnance_patient');
      }
}
