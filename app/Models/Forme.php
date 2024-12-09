<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forme extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'nom',
        'description',
        'worked'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function produits(){
        return $this->hasMany('App\Models\Produit','forme_id','id');
    }
}
