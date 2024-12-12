<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
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
        return $this->belongsToMany('App\Models\Produit', 'client_produit');
     }
 
    
}
