<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Concerns\HasUlids;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

     
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'user_creator_id',
        'name',
        'email',
        'firstname',
        'phone',
        'sexe',
        'birthdate',
        'image',
        'signature',
        'online',
        'etat',
        'password'       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin($admin)
    {
        $res =  $this->roles()->where('name', $admin)->first();
        if (!empty($res)) {
            if ($res['name'] == "admin") {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isPharmacien($pharmacien)
    {

        if ($pharmacien == "Pharmacien") {
            return true;
        } else {
            return false;
        }
    }

    public function isCaissier($caissier)
    {

        if ($caissier == "Caissier") {
            return true;
        } else {
            return false;
        }
    }

    public function isControlleur($controlleur)
    {

        if ($controlleur == "Controlleur") {
            return true;
        } else {
            return false;
        }
    }

    

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * The matieres created by User 
     */

     public function defautLiraisons(){
        return $this->hasMany('App\Models\DefautLivraison','user_id','id');
     }

    /**
     * The classes created by User 
     */

     public function familles(){
        return $this->hasMany('App\Models\Famille','user_id','id');
     }

     public function formes(){
        return $this->hasMany('App\Models\Forme','user_id','id');
     }

     public function fournisseurs(){
        return $this->hasMany('App\Models\Fournisseur','user_id','id');
     }

     public function medecins(){
        return $this->hasMany('App\Models\Medecin','user_id','id');
     }

     public function ordonnances(){
        return $this->hasMany('App\Models\Ordonnance','user_id','id');
     }

     public function patients(){
        return $this->hasMany('App\Models\Patient','user_id','id');
     }

     public function produits(){
        return $this->hasMany('App\Models\Produit','user_id','id');
     }

     public function reglements(){
        return $this->hasMany('App\Models\Reglement','user_id','id');
     }

     public function ventes(){
        return $this->hasMany('App\Models\Vente','user_id','id');
     }

     

}
