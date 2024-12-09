<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Reglement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des fourniseurs',
            'table' => 'Fournisseurs'
            ];
            
            $user = User::where('id', '=', Auth::user()->id)->first();
            $fournisseurs = Fournisseur::where('worked','=',1)->latest()->paginate('10');
            return view('adminpages.fournisseur.indexfournisseur',compact('fournisseurs','user','tableau'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  fournissuer',
            'table' => 'Fournisseurs'
            ];

           $user = User::where('id', '=', Auth::user()->id)->first();
           return view('adminpages.fournisseur.createfournisseur',compact('user','tableau')); 

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'raisonSocial' => 'required',
            'adresse' => 'required',
            'email' => 'required|email|unique:fournisseurs',
            'telephone' => 'required|min:8',

        ]);
       //dd($request->input());
        DB::beginTransaction();
        try{
            $fournisseur = new Fournisseur;
            $fournisseur->uuid = (string)Str::uuid();
            $fournisseur->user_id = Auth::user()->id;
            $fournisseur->raisonSocial = $request->raisonSocial;
            $fournisseur->adresse = $request->adresse;
            $fournisseur->telephone = $request->telephone;
            $fournisseur->email = $request->email;
            $fournisseur->worked = 1;
            $query = $fournisseur->save();
            if($query){
               return back()->with('success','Votre enregistrement a été fait avec succès'); 
            }
            DB::commit();
           }catch (\Throwable $e) {
                    DB::rollback();
                    throw $e;
                }  
        
        
    }

 
  

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        //
    }

    public function indexCommande(){
        $tableau = [
            'liste' => 'Lancer  commandes',
            'table' => 'Commandes'
            ];
            
           $user = User::where('id', '=', Auth::user()->id)->first();
           $fournisseurs = Fournisseur::where('worked','=',1)->get();
           return view('adminpages.commandefournisseur.indexcommandefournisseur',compact('fournisseurs','user','tableau')); 
    }

    public function createCommande(Request $request){
        if ($request->fournisseur == "Veuillez Selectionner" ) {
            return redirect()->route('fournisseur.indexCommande')->with('errorchamps', 'Echec!!!Veuillez selectionner le champ fournisseur'); 
        }
        $tableau = [
            'liste' => 'Créer  commande',
            'table' => 'Commandes'
            ];
           $request->session()->put('keyFournisseur', $request->fournisseur);
           $user = User::where('id', '=', Auth::user()->id)->first();
           return view('adminpages.commandefournisseur.createcommandefournisseur',compact('user','tableau')); 

    }

    public function commandeFournisseur(Request $request){
      //var_dump($request->session()->get('keyFournisseur'));
      //dd($request->input());
      $today = Carbon::now();
      
      $produit = $request->item_produit;
      $quantite = $request->item_quantite;
      $dateExpereLivraison = $request->item_datecommande;
      $idFournisseur = $request->session()->get('keyFournisseur');
        
        //dd($image);
        for ($i = 0; $i < count($produit); $i++) {
         $verif = DB::table('fournisseur_produit')->where([
            ['produit_id','=', $produit[$i]],
            ['commandé','=','en_cours'],
            ['fournisseur_id','=',$idFournisseur]
         ])->get()->count();
         if($verif>0){
            return redirect()->route('fournisseur.indexCommande')->with('errorchamps','Echec de tentative. Il y a des produits dans cette liste qui étaient commandés auprès de ce fournisseur et qui sont en attente de livraison. Consulter votre fiche de commande en cours et veilleuz le relancer.Merci.'); 

         }
            $dataSave = [
                'fournisseur_id' => $idFournisseur,
                'user_id' => Auth::user()->id,
                'uuid' => (string)Str::uuid(),
                'produit_id' => $produit[$i],
                'reglement_id' => 1,
                'livraison_id' => 1,
                'dateCommande' => $today,
                'dateExpereLivraison' => $dateExpereLivraison[$i],
                'quantiteCommande' => $quantite[$i],
                'commandé' => "en_cours",
                'worked' => 1,
                'livré' => "pas_encore",
                'résolu' => "en_cours",
                'created_at' => $today,
                'updated_at' => $today,               
                'numeroCommande' => 0,               
            ];
            

            //DB::table('documents')->insert($dataSave);
            DB::table('fournisseur_produit')->insertGetId($dataSave);
            

        }
        return redirect()->route('fournisseur.indexCommande')->with('success','Votre enregistrement a été fait avec succès'); 
    }

    public function rechercherLesommandes(Request $request){
        $tableau = [
            'liste' => 'Liste  commandes',
            'table' => 'Commandes'
            ];
          
           $request->session()->put('keyFourni',$request->fournisseur);
           $request->session()->put('keyEtat',$request->etat);
           $user = User::where('id', '=', Auth::user()->id)->first();
           $fournisseurs = Fournisseur::where('worked','=',1)->get();
           return view('adminpages.commandefournisseur.recherchercommandefournisseur',compact('fournisseurs','user','tableau')); 
    }

    public function afficherRecherches(Request $request){
        //dd($request->input());
        if ($request->fournisseur == "Veuillez Selectionner" || $request->etat == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs fournisseur, ou état');
        }
        $tableau = [
            'liste' => 'Liste  commandes',
            'table' => 'Commandes'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $etat = "";
      
        if($request->etat == "en_cours"){
            $etat = "Commandes en cours"; 
        }else if($request->etat == "livré"){
            $etat = "Commandes livrées"; 
        }else if($request->etat == "annulé"){
            $etat = "Commandes annulées"; 
        }
        $fournisseur = $request->fournisseur;
        $data = Fournisseur::find($fournisseur);
        $request->session()->put('keyf',$fournisseur);
        $request->session()->put('keye',$request->etat);
        $uuid = $data->uuid;
        $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',$request->etat)
            ->where('fournisseur_produit.fournisseur_id','=',$request->fournisseur)
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
                      ->limit(5)->get();
                      //$commandes = retreiveInfoFournisseurProduit($request->etat,$request->fournisseur);
                      return view('adminpages.commandefournisseur.listecommandefournisseur',compact('commandes','user','tableau','etat','fournisseur','uuid'));        
    }

    public function demarrerTraitementLivraison(Request $request){
        $tableau = [
            'liste' => 'Démarrer  Traitement Livraison',
            'table' => 'Livraison'
            ];
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url, 27);
        //dd($request->session()->get('keye'));
        $commande = retreiveInfo($uuid);
        $commandeencours = retreiveInfoFournisseurProduit($request->session()->get('keye'),$request->session()->get('keyf'));
        //dd($commandeencours);
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('adminpages.commandefournisseur.fichetraitementcommande',compact('user','tableau','commande','commandeencours')); 

    }

    public function traiterCommander2(Request $request){
      //dd($request->input());
      $request->validate([
        'nature' => 'required',
        'montant' => 'required|numeric'
    ]);
  
      if ($request->nature == "Veuillez Selectionner") {
        return back()->with('errorchamps', 'Echec!!!Veuillez selectionner le champ nature de paiement');
    }
      $today = Carbon::now();
      $produit = $request->item_produit;
      $quantite = $request->item_quantitelivree;
      $prix = $request->item_prixlivraison;
      $idFournisseur = $request->session()->get('keyf');
      $image = $request->file('fichier');
      $my_image = rand() . '.' . $image->getClientOriginalExtension();
      $image->move($_SERVER['DOCUMENT_ROOT'] . '/upload', $my_image);
      $reglement = new Reglement;
      $reglement->natureReglement = $request->nature;
      $reglement->user_id = Auth::user()->id;
      $reglement->uuid = (string)Str::uuid(); 
      $reglement->preuve = $my_image;
      $reglement->montantTotal = $request->montant;
      $query = $reglement->save();
      $insertedId = $reglement->id; 
      $cmd = DB::table('fournisseur_produit')->where([
        ['fournisseur_id','=',$idFournisseur],
        ['numeroCommande','=',0]
      ]
        )->take(1)
        ->get();
      session(['cmds' => $cmd]);
      $idEtat = $request->session()->get('keye');
        for ($i = 0; $i < count($produit); $i++) {
            
                                 DB::update('update  fournisseur_produit 
                                 set quantiteLivraison = ?,
                                  dateLivraison = ?, 
                                  updated_at = ?, 
                                  prixLivraison = ?, 
                                  commandé = ?,
                                  numeroCommande = ?,
                                   reglement_id = ? where produit_id = ? and numeroCommande = ?', 
                                   [
                                    $quantite[$i],
                                    $today,
                                    $today,
                                    $prix[$i],
                                    "livré",
                                    1,
                                    $insertedId,$produit[$i],0
                                   ]);
                                   $stok = Stock::where('produit_id','=', $produit[$i])->first();
                                   if(empty($stok)){
                                    //dd('ok');
                                   
                                    $tableau = [
                                        'produit_id' => $produit[$i],
                                        'quantité' => $quantite[$i],
                                        'created_at' => $today,
                                        'updated_at' => $today
                                    ];
                                    DB::table('stocks')->insertGetId($tableau);
                                   }else{
                                    //dd('ok');               
                                    $stk = Stock::find($stok->id);
                                    $stk->quantité = $stk->quantité+$quantite[$i];                                   
                                    $stk->updated_at = $today;
                                    $stk->save();
                                   }                   
                      }                                        
                    //dd($res);
                    return back()->with('success','Votre enregistrement a été fait avec succès');                  
    }
    public function traiterCommande(Request $request){
      //dd($request->input());
      $request->validate([
        'nature' => 'required',
        'montant' => 'required|numeric',
        'quantiteSeuil' => 'numeric',
        'quantiteAlerte' => 'numeric',
    ]);
    if($request->quantiteSeuil!="" || $request->quantiteAlerte!=""){
        $request->validate([
            'quantiteSeuil' => 'numeric',
            'quantiteAlerte' => 'numeric',
        ]);
        /*if($request->quantiteSeuil > $request->quantiteAlert){
            return back()->with('errorchamps', 'Echec!!!la quantité alerte doit être plus grande que celle du  seuil.');
        }*/
    }
      if ($request->nature == "Veuillez Selectionner") {
        return back()->with('errorchamps', 'Echec!!!Veuillez selectionner le champ nature de paiement');
    }
      $today = Carbon::now();
      $produit = $request->item_produit;
      $quantite = $request->item_quantitelivree;
      $prix = $request->item_prixlivraison;
      $idFournisseur = $request->session()->get('keyf');
      $image = $request->file('fichier');
      $my_image = rand() . '.' . $image->getClientOriginalExtension();
      $image->move($_SERVER['DOCUMENT_ROOT'] . '/upload', $my_image);
      $reglement = new Reglement;
      $reglement->natureReglement = $request->nature;
      $reglement->user_id = Auth::user()->id;
      $reglement->uuid = (string)Str::uuid(); 
      $reglement->preuve = $my_image;
      $reglement->montantTotal = $request->montant;
      $query = $reglement->save();
      $insertedId = $reglement->id; 
      $cmd = DB::table('fournisseur_produit')->where([
        ['fournisseur_id','=',$idFournisseur],
        ['numeroCommande','=',0]
      ]
        )->take(1)
        ->get();
      session(['cmds' => $cmd]);
      $idEtat = $request->session()->get('keye');
        for ($i = 0; $i < count($produit); $i++) {
            
                                 DB::update('update  fournisseur_produit 
                                 set quantiteLivraison = ?,
                                  dateLivraison = ?, 
                                  updated_at = ?, 
                                  prixLivraison = ?, 
                                  commandé = ?,
                                  numeroCommande = ?,
                                   reglement_id = ? where produit_id = ? and numeroCommande = ?', 
                                   [
                                    $quantite[$i],
                                    $today,
                                    $today,
                                    $prix[$i],
                                    "livré",
                                    1,
                                    $insertedId,$produit[$i],0
                                   ]);
                                   $stok = Stock::where('produit_id','=', $produit[$i])->first();
                                   if(empty($stok)){
                                    //dd('ok');
                                   
                                    $tableau = [
                                        'produit_id' => $produit[$i],
                                        'quantité' => $quantite[$i],
                                        'quantiteSeuil' => $request->quantiteSeuil,
                                        'quantiteAlert' => $request->quantiteAlerte,
                                        'created_at' => $today,
                                        'updated_at' => $today
                                    ];
                                    DB::table('stocks')->insertGetId($tableau);
                                   }else{
                                    //dd('ok');               
                                    $stk = Stock::find($stok->id);
                                    $stk->quantité = $stk->quantité+$quantite[$i];
                                    if($request->quantiteSeuil!=""){
                                        $stk->quantiteSeuil = $request->quantiteSeuil;
                                    }
                                    if($request->quantiteAlerte!=""){
                                        $stk->quantiteAlert = $request->quantiteAlerte;
                                    }
                                    $stk->updated_at = $today;
                                    $stk->save();
                                   }                   
                      }                                        
                    //dd($res);
                    return back()->with('success','Votre enregistrement a été fait avec succès');                  
    }

   
    public function getAllCommandeEncours(){
        $tableau = [
            'liste' => 'Démarrer  Traitement Livraison',
            'table' => 'Livraison'
            ];
        $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',session()->get('keye'))
            ->where('fournisseur_produit.fournisseur_id','=',session()->get('keyf'))
            ->select('fournisseur_produit.user_id as idfourniproduserId',
                     'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
                     'fournisseur_produit.produit_id as idfourniprodproId',
                     'fournisseur_produit.uuid as uuidfourniprod',
                     'fournisseur_produit.dateCommande as datefourniprod',
                     'fournisseur_produit.quantiteCommande as quantitefourniprod',
                     'fournisseur_produit.created_at as created_at',
                     'fournisseur_produit.updated_at as updated_at',
                     'fournisseur_produit.id as pivotId',
                     'produits.nom as produitnom',
                     'fournisseurs.raisonSocial as raisonSocial'
                      )
                      ->orderBy('created_at','DESC')
                      ->latest()->paginate(10);
                      $user = User::where('id', '=', Auth::user()->id)->first();
                      //$commandes = retreiveInfoFournisseurProduit($request->etat,$request->fournisseur);
                      return view('adminpages.commandefournisseur.listecommandeencours',compact('commandes','user','tableau'));
    }
    
    public function getAllCommandeLivree(){
        $tableau = [
            'liste' => 'Démarrer  Traitement Livraison',
            'table' => 'Livraison'
            ];
        $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',session()->get('keye'))
            ->where('fournisseur_produit.fournisseur_id','=',session()->get('keyf'))
            ->select('fournisseur_produit.user_id as idfourniproduserId',
                     'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
                     'fournisseur_produit.produit_id as idfourniprodproId',
                     'fournisseur_produit.uuid as uuidfourniprod',
                     'fournisseur_produit.dateCommande as datefourniprod',
                     'fournisseur_produit.quantiteCommande as quantitefourniprod',
                     'fournisseur_produit.created_at as created_at',
                     'fournisseur_produit.updated_at as updated_at',
                     'fournisseur_produit.id as pivotId',
                     'produits.nom as produitnom',
                     'fournisseurs.raisonSocial as raisonSocial'
                      )
                      ->orderBy('created_at','DESC')
                      ->latest()->paginate(10);
                      $user = User::where('id', '=', Auth::user()->id)->first();
                      //$commandes = retreiveInfoFournisseurProduit($request->etat,$request->fournisseur);
                      return view('adminpages.commandefournisseur.listecommandelivree',compact('commandes','user','tableau'));
    }

    public function listStock(){
        $tableau = [
            'liste' => 'Démarrer  Traitement Livraison',
            'table' => 'Livraison'
            ];
        $stocks = Stock::latest()->paginate(10);
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('adminpages.commandefournisseur.listestock',compact('stocks','tableau','user'));
    }

    public function editStock(Stock $stock){
        $tableau = [
            'liste' => 'Modification stoock',
            'table' => 'Stock'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,16); 
            //dd($uuid);
            $stock = Stock::where('id',$uuid)->first();
              return view('adminpages.commandefournisseur.editstock',compact('user','stock','tableau'));
    }

      /**
     * Update the specified resource in storage.
     */
    public function updateStock(Request $request, Stock $stock)
    {
        ///dd($request->input());
        $request->validate([
            'quantiteAlert' => 'required|numeric|min:2',
            'quantiteSeuil' => 'required|numeric|min:2'
            ]); 
            if($request->quantiteSeuil >= $request->quantiteAlert){
                return back()->with('errorchamps', 'Echec!!!la quantité alerte doit être plus grande que celle du  seuil.');
            } 
             $url = $_SERVER['REQUEST_URI'];
             $uuid = substr($url,16); 
             //dd($uuid);
             DB::beginTransaction();

            try {

                $stock = Stock::find($request->id);
                $stock->quantiteAlert = $request->quantiteAlert;
                $stock->quantiteSeuil = $request->quantiteSeuil;
                $stock->save();
                $produit  = Produit::find($stock->produit_id);
                $produit->quantiteAlert = $request->quantiteAlert;
                $produit->quantiteSeuil = $request->quantiteSeuil;
                $produit->save();
                return redirect()->route('stock.liststock')->with('success','La famille a été modifiée avec succès');
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }         
   
    }

    public function imprimeFournisseur(){
        $user = User::where('id', '=', Auth::user()->id)->first();
        $data = [
           'fournisseurs' =>Fournisseur::where('worked','=',1)->get()
       ];
        
        $pdf = Pdf::loadView('imprimeetatfournisseurspdf',$data);
        return $pdf->download('imprimeetatfournisseurspdf.pdf');
        
      }
    public function imprimeListecommandeFournisseur(){
        $user = User::where('id', '=', Auth::user()->id)->first();
        
        $data = [
           'commandes' =>  DB::table('fournisseur_produit')
           ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
           ->join('produits','fournisseur_produit.produit_id','=','produits.id')
           ->where('fournisseur_produit.commandé','=',session()->get('keye'))
           ->where('fournisseur_produit.fournisseur_id','=',session()->get('keyf'))
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
                    ->get()
       ];
        
        $pdf = Pdf::loadView('printcommandefournisseurpdf',$data);
        return $pdf->download('printcommandefournisseurpdf.pdf');
        
      }
}
