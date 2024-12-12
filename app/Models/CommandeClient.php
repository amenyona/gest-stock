<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'datePrescription',
        'worked'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function produits(){
        return $this->belongsToMany('App\Models\Produit', 'client_produit');
     }
 
}
