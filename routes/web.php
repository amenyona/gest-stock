<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\FormeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\RequeteController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/dashboard', function () {
$user = User::where('id', '=', Auth::user()->id)->first();
return view('adminpages.dashboardcontent',compact('user'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
Route::get('/lists-des-utilisateurs', [UserController::class, 'index'])->name('user.index');
Route::get('/createuser', [UserController::class, 'create'])->name('user.create');
Route::post('/storeuser', [UserController::class, 'store'])->name('user.store');
Route::post('/user-inscription', [UserController::class, 'storeinscription'])->name('user.storeinscription');
Route::get('/edituser', [UserController::class, 'edit'])->name('user.edit');
Route::put('/modifier', [UserController::class, 'update'])->name('auth.update');
Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('auth.delete');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/liste-des-rôles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/rolecreate', [RoleController::class, 'create'])->name('roles.create');
Route::post('/rolestore', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roleshow', [RoleController::class, 'show'])->name('roles.show');
Route::get('/roleedit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roleupdate', [RoleController::class, 'update'])->name('roles.update');
Route::get('/deleterole/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::get('/liste-des-familles',[FamilleController::class,'index'])->name('famille.index');
Route::get('/creer-famille',[FamilleController::class,'create'])->name('famille.create');
Route::post('/store-famille',[FamilleController::class,'store'])->name('famille.store');
Route::get('/edit-famille',[FamilleController::class,'edit'])->name('famille.edit');
Route::put('/update-famille',[FamilleController::class,'update'])->name('famille.update');
Route::get('/deletefamille/{id}',[FamilleController::class,'destroy'])->name('famille.destroy');
Route::get('/imprim-etat-famille}',[FamilleController::class,'imprimeFournisseur'])->name('famille.imprimeFournisseur');
Route::get('/liste-des-formes',[FormeController::class,'index'])->name('forme.index');
Route::get('/creer-forme',[FormeController::class,'create'])->name('forme.create');
Route::post('/store-forme',[FormeController::class,'store'])->name('forme.store');
Route::get('/edit-forme',[FormeController::class,'edit'])->name('forme.edit');
Route::put('/update-forme',[FormeController::class,'update'])->name('forme.update');
Route::get('/imprim-etat-forme',[FormeController::class,'imprime'])->name('forme.imprime');
Route::get('/deleteforme/{id}',[FormeController::class,'destroy'])->name('forme.destroy');
Route::get('/liste-des-produits',[ProduitController::class,'index'])->name('produit.index');
Route::get('/creer-produit',[ProduitController::class,'create'])->name('produit.create');
Route::post('/store-produit',[ProduitController::class,'store'])->name('produit.store');
Route::get('/edit-produit',[ProduitController::class,'edit'])->name('produit.edit');
Route::put('/update-produit',[ProduitController::class,'update'])->name('produit.update');
Route::get('/imprim-etat-produit',[ProduitController::class,'imprime'])->name('produit.imprime');
Route::get('/liste-des-forunisseurs',[FournisseurController::class,'index'])->name('fournisseur.index');
Route::get('/creer-forunisseur',[FournisseurController::class,'create'])->name('fournisseur.create');
Route::post('/store-forunisseur',[FournisseurController::class,'store'])->name('fournisseur.store');
Route::get('/lancer-commande',[FournisseurController::class,'indexCommande'])->name('fournisseur.indexCommande');
Route::post('/creer-commande',[FournisseurController::class,'createCommande'])->name('fournisseur.createCommande');
Route::post('/store-commande',[FournisseurController::class,'commandeFournisseur'])->name('fournisseur.commandeFournisseur');
Route::get('/rechercher-options-commande',[FournisseurController::class,'rechercherLesommandes'])->name('fournisseur.rechercherLesommandes');
Route::post('/afficher-commande',[FournisseurController::class,'afficherRecherches'])->name('fournisseur.afficherRecherches');
Route::get('/debut-traitement-commande',[FournisseurController::class,'demarrerTraitementLivraison'])->name('fournisseur.demarrerTraitementLivraison');
Route::post('/traiter-commande',[FournisseurController::class,'traiterCommande'])->name('fournisseur.traiterCommande');
Route::get('/commandes-encours',[FournisseurController::class,'getAllCommandeEncours'])->name('fournisseur.commandesencours');
Route::get('/commandes-livreees',[FournisseurController::class,'getAllCommandeLivree'])->name('fournisseur.commandeslivrees');
Route::get('/liste-stocks',[FournisseurController::class,'listStock'])->name('stock.liststock');
Route::get('/modifier-stock',[FournisseurController::class,'editStock'])->name('stock.editStock');
Route::put('/update-stock',[FournisseurController::class,'updateStock'])->name('stock.updateStock');
Route::get('/imprime-etat-commande-fournissuer',[FournisseurController::class,'imprimeListecommandeFournisseur'])->name('fournisseur.imprimeListecommandeFournisseur');
Route::get('/imprime-etat-fournissuer',[FournisseurController::class,'imprimeFournisseur'])->name('fournisseur.imprimeFournisseur');
Route::get('/liste-des-ventes',[VenteController::class,'index'])->name('ventes.listes');
Route::get('/creer-vente',[VenteController::class,'create'])->name('ventes.create');
Route::post('/store-vente',[VenteController::class,'store'])->name('ventes.store');
Route::get('/afficher-ventes-du-jour',[VenteController::class,'getTodayVente'])->name('ventes.getTodayVente');
Route::post('/ventes/fetch-produit-prix',[VenteController::class,'fetchProduitPrix'])->name('ventes.fetchProduitPrix');
Route::get('/liste-des-medecins',[MedecinController::class,'index'])->name('medecin.liste');
Route::get('/creer-medecin',[MedecinController::class,'create'])->name('medecin.create');
Route::post('/store-medecin',[MedecinController::class,'store'])->name('medecin.store');
Route::get('/modifier-medecin',[MedecinController::class,'edit'])->name('medecin.edit');
Route::put('/update-medecin',[MedecinController::class,'update'])->name('medecin.update');
Route::get('/delete-medecin/{id}',[MedecinController::class,'destroy'])->name('medecin.delete');
Route::get('/liste-des-patients',[PatientController::class,'index'])->name('patient.liste');
Route::get('/creer-patient',[PatientController::class,'create'])->name('patient.create');
Route::post('/store-patient',[PatientController::class,'store'])->name('patient.store');
Route::get('/modifier-patient',[PatientController::class,'edit'])->name('patient.edit');
Route::put('/update-patient',[PatientController::class,'update'])->name('patient.update');
Route::get('/delete-patient/{id}',[PatientController::class,'destroy'])->name('patient.delete');
Route::get('/creer-ordonnance',[OrdonnanceController::class,'create'])->name('ordonnance.create');
Route::post('/store-ordonnance',[OrdonnanceController::class,'store'])->name('ordonnance.store');
Route::get('/fiche-des-requêtes',[RequeteController::class,'requeteFiche'])->name('requete.requeteFiche');
Route::get('/stock-alert',[RequeteController::class,'stockAlert'])->name('stock.stockAlert');
Route::get('/rechercher-stock-alert',[RequeteController::class,'rechercherStockAlert'])->name('stock.rechercherStockAlert');
Route::get('/rechercher-stock-seuil',[RequeteController::class,'rechercherStockSeuil'])->name('stock.rechercherStockSeuil');
Route::get('/rechercher-stock-alert-imprim',[RequeteController::class,'imprimeAlert'])->name('stock.imprimeAlert');
Route::get('/rechercher-stock-seuil-imprim',[RequeteController::class,'imprimeSeuil'])->name('stock.imprimeSeuil');
//Route::post('/rechercher-stock-alert',[RequeteController::class,'rechercherStockAlert'])->name('stock.rechercherStockAlert');

});

Route::get('pdf',function(){
    $data = [
        'users' =>User::all()
    ];
    $pdf = Pdf::loadView('user-pdf',$data);
    //return $pdf->download('user-pdf.pdf');
    return $pdf->stream();
});

require __DIR__.'/auth.php';
