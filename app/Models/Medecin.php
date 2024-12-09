<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'pernom',
        'telephone',
        'email',
        'worked'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }


    public function ordonnances(){
       return $this->belongsToMany('App\Models\Ordonnance', 'medecin_ordonnance_patient');
    }

    public function patients(){
       return $this->belongsToMany('App\Models\Patient', 'medecin_ordonnance_patient');
     }

    

}
