<?php

namespace App\Models;
use App\Models\User;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Reglement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefautLivraison extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'uuid',
        'typeDefaut',
        'description',
        'dateSignalement',
        'dateResolution',
        'worked'
    ];

    /**
     * créée par l'utilisateur
     */

     public function user(){
        return $this->belongsTo(User::class, 'user_id');
     }
}
