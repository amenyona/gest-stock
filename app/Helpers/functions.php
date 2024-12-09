<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Support\Str;


function renvoiRoleAdminn($id){
    $roleUser = User::find($id)->roles()->get();
    $resu = User::first()->isAdmin($roleUser[0]['name']);
    return $resu;
}
function renvoiRolePharmacien($id){
    $roleUser = User::find($id)->roles()->get();
    $resu = User::first()->isPharmacien($roleUser[0]['name']);
    return $resu;
}

function renvoiRoleCaissier($id){
    $roleUser = User::find($id)->roles()->get();
    //dd($roleUser);
    $resu = User::first()->isCaissier($roleUser[0]['name']);
    //dd($resu);
    return $resu;
}

function renvoiRoleControlleur($id){
    $roleUser = User::find($id)->roles()->get();
    $resu = User::first()->isControlleur($roleUser[0]['name']);
    //dd($resu);
    return $resu;
}


function renvoiRoleUserTuteur($id)
{
    $roleUser = User::find($id)->roles()->get();
    //dd($roleUser[0]['id']);
    $resu = User::first()->isTuteur($roleUser[0]['name']);
    //dd($resu);
    return $resu;
    
}

function retreiveEmail($email){
    $res = User::where('email',$email)->get()->count();
    if($res>0){
        return true;
    }else{
        return false;
    }

}

function renvoiProduitfs($arg1,$arg2){
    $idEntreprise = User::find(Auth::user()->id)->first();
    //$produits = Produit::where('worked','=',1)->get();
    $produits = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',$arg1)
            ->where('produits.worked','=',1)
            ->where('fournisseur_produit.fournisseur_id','=',$arg2)
            ->select('fournisseur_produit.user_id as idfourniproduserId',
                     'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
                     'fournisseur_produit.produit_id as idfourniprodproId',
                     'fournisseur_produit.uuid as uuidfourniprod',
                     'fournisseur_produit.dateCommande as datefourniprod',
                     'fournisseur_produit.quantiteCommande as quantitefourniprod',
                     'fournisseur_produit.created_at as created_at',
                     'fournisseur_produit.updated_at as updated_at',
                     'produits.nom as produitnom',
                     'produits.id as produitid',
                     'fournisseurs.raisonSocial as raisonSocial'
                      )->orderBy('created_at','DESC')
                      ->get();
    //dd($produits);
    $output = '<option value="Veuillez Sélectionner">'."Veuillez S&eacute;lectionner".'</option>';
    foreach($produits as $row){
        $output .= '<option value="'.$row->produitid.'">'.$row->produitnom.'</option>';
    }
    return $produits; 
}
function renvoiProduits(){
    $user = User::find(Auth::user()->id)->first();
  $produits = Produit::where('worked','=',1)->get();
 
    $output = '<option value="Veuillez Sélectionner">'."Veuillez S&eacute;lectionner".'</option>';
    foreach($produits as $row){
        $output .= '<option value="'.$row->id.'">'.$row->nom.'</option>';
    }
    return $produits; 
}
function renvoiProduitss(){
    $user = User::find(Auth::user()->id)->first();
    $produits = Produit::where([['worked','=',1]])->get();
    return $produits; 
}

function retreiveFournisseur($idFournisseur){
$fournisseur = Fournisseur::find($idFournisseur);
return $identites = $fournisseur['raisonSocial'];
}

function retreiveNomProduit($produitId){
$produit = Produit::find($produitId);
return $produit->nom;
}

function retreivePrixProduit($produitId){
$produit = Produit::find($produitId);
return $produit->prix;
}

function retreiveInfoFournisseurProduit($arg1, $arg2){
    $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',$arg1)
            ->where('fournisseur_produit.fournisseur_id','=',$arg2)
            ->select('fournisseur_produit.user_id as idfourniproduserId',
                     'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
                     'fournisseur_produit.produit_id as idfourniprodproId',
                     'fournisseur_produit.uuid as uuidfourniprod',
                     'fournisseur_produit.dateCommande as datefourniprod',
                     'fournisseur_produit.quantiteCommande as quantitefourniprod',
                     'fournisseur_produit.created_at as created_at',
                     'fournisseur_produit.updated_at as updated_at',
                     'produits.nom as produitnom',
                     'fournisseurs.raisonSocial as raisonSocial'
                      )
                      ->orderBy('created_at','DESC')
                      ->latest()->paginate('2');
    return $commandes;
}

function countCommande($arg1,$arg2){
    $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',$arg1)
            ->where('fournisseur_produit.fournisseur_id','=',$arg2)
            ->select('fournisseur_produit.user_id as idfourniproduserId',
                     'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
                     'fournisseur_produit.produit_id as idfourniprodproId',
                     'fournisseur_produit.uuid as uuidfourniprod',
                     'fournisseur_produit.dateCommande as datefourniprod',
                     'fournisseur_produit.quantiteCommande as quantitefourniprod',
                     'fournisseur_produit.created_at as created_at',
                     'fournisseur_produit.updated_at as updated_at',
                     'produits.nom as produitnom',
                     'fournisseurs.raisonSocial as raisonSocial'
                      )->get()->count();
        return $commandes;

}

function retreiveInfo($arg){
    $commande = DB::table('fournisseur_produit')
    ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
    ->join('produits','fournisseur_produit.produit_id','=','produits.id')
    ->where('fournisseur_produit.uuid','=',$arg)
    ->select('fournisseur_produit.user_id as idfourniproduserId',
             'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
             'fournisseur_produit.produit_id as idfourniprodproId',
             'fournisseur_produit.uuid as uuidfourniprod',
             'fournisseur_produit.dateCommande as datecomdefourniprod',
             'fournisseur_produit.quantiteCommande as quantitecomdefourniprod',
             'fournisseur_produit.created_at as created_at',
             'fournisseur_produit.updated_at as updated_at',
             'produits.nom as produitnom',
             'fournisseurs.raisonSocial as raisonSocial',
             'fournisseurs.id as idfournisseur',
              )->get();
return $commande;
}












