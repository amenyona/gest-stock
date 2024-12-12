<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Reglement;
use App\Models\Livraison;
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
        $tableau = [
            'liste' => 'Modification Fournisseur',
            'table' => 'Fournisseurs'
            ];
  
        $user = User::where('id','=',Auth::user()->id)->first();
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,18); 
        $fournisseur = Fournisseur::where('uuid',$uuid)->first();
        //dd($fournisseur);
        return view('adminpages.fournisseur.editfournisseur',compact('user','fournisseur','tableau'));  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        //dd($request->input());
        $request->validate([
            'raisonSocial' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            ]);  
             $url = $_SERVER['REQUEST_URI'];
             $uuid = substr($url,12); 
             //dd($uuid);
             DB::beginTransaction();

            try {

        $fournisseur = Fournisseur::find($request->fournissuerId);
        //dd($fournisseur);
        $fournisseur->user_id = Auth::user()->id;
        $fournisseur->raisonSocial = $request->raisonSocial;
        $fournisseur->adresse = $request->adresse;
        $fournisseur->telephone = $request->telephone;
        $fournisseur->email = $request->email;
        $query = $fournisseur->save();
        if($query){
            return redirect()->route('fournisseur.index')->with('success','Votre modification a été faite avec succès'); 
        }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,20);
        //dd($uuid);
        $fournisseurinfo = Fournisseur::where('uuid', $uuid)->first();
        $fournisseur = Fournisseur::find($fournisseurinfo['id']);
        //dd($fournisseur);
        $fournisseur->user_id = Auth::user()->id;
        $fournisseur->worked = 0;;
        $query = $fournisseur->save();
        return redirect()->route('fournisseur.index')->with('success','Votre suppression a été faite avec succès'); 

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

    public function generate_cs()
    {
        $c1 = "DONBOSCO";
        $c2 = rand(1, 99999);
        $c2 = str_pad($c2, 5, '0', STR_PAD_LEFT);
        $c3 = range('a', 'z');
        shuffle($c3);
        $c3 = strtoupper($c3[0]);
        $c = $c1 . $c2 . $c3;
        return $c;
    }

    public function commandeFournisseur(Request $request){
      //var_dump($request->session()->get('keyFournisseur'));
      //dd($request->input());
      $today = Carbon::now();
      $numero = $this->generate_cs();
      $produit = $request->item_produit;
      $quantite = $request->item_quantite;
      $dateExpereLivraison = $request->item_datecommande;
      $idFournisseur = $request->session()->get('keyFournisseur'); 
      $request->session()->put('datecommande', $today);       
      $request->session()->put('numerocommande', $numero);       
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
                'dateCommande' => $today,
                'dateExpereLivraison' => $dateExpereLivraison[$i],
                'quantiteCommande' => $quantite[$i],
                'commandé' => "en_cours",
                'worked' => 1,
                'livré' => "pas_encore",
                'résolu' => "en_cours",
                'created_at' => $today,
                'updated_at' => $today,               
                'numeroCommande' => $numero,               
            ];
            $res [] = [
                'fournisseur_id' => $idFournisseur,
                'user_id' => Auth::user()->id,
                'uuid' => (string)Str::uuid(),
                'produit_id' => $produit[$i],
                'dateCommande' => $today,
                'dateExpereLivraison' => $dateExpereLivraison[$i],
                'quantiteCommande' => $quantite[$i],
                'commandé' => "en_cours",
                'worked' => 1,
                'livré' => "pas_encore",
                'résolu' => "en_cours",
                'created_at' => $today,
                'updated_at' => $today,               
                'numeroCommande' => $numero, 
            ];
            

            //DB::table('documents')->insert($dataSave);
            DB::table('fournisseur_produit')->insertGetId($dataSave);
            

        }
        $data = [
            'commandes' =>$res
        ];

         $pdf = Pdf::loadView('adminpages.etats.bordereaucommandefournisseur',$data);
        return $pdf->download('bordereaucommandefournisseur.pdf');
        //return redirect()->route('fournisseur.indexCommande')->with('success','Votre enregistrement a été fait avec succès'); 
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

       public function fetchNumeroCommande(Request $request){
                $select = $request->get('select');
                $value = $request->get('value');
                $dependent = $request->get('dependent');
                $query = DB::table('fournisseur_produit')
                ->where([
                    ['fournisseur_id','=',session()->get('fournisseurIdC')],
                    ['commandé','=',$value]
                ])->select('numeroCommande')
                ->groupBy('numeroCommande')
                ->get();
                $output = '<option value="Veuillez Sélectionner">Sélectionner un '.$dependent.'</option>';
                foreach($query as $row){
                    $output .= '<option value="'.$row->numeroCommande.'">'.$row->numeroCommande.'</option>';
                }
                echo $output;
                
            }
    public function fetchFoirnisseurId(Request $request)
    {
        $value = $request->get('value');
        if (isset($value)) {
            $request->session()->put('fournisseurIdC',$value);
            return response()->json(['message' => ' trouvé'], 200);
        } else {
            return response()->json(['message' => 'Valeur manquante'], 400);
        }
    }

    public function indexCommandesFournisseur(Request $request){
        $tableau = [
            'liste' => 'Liste  commandes',
            'table' => 'Commandes'
            ];

        $user = User::where('id', '=', Auth::user()->id)->first();
        $fournisseurs = Fournisseur::where('worked','=',1)->get();
        $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
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
                      ->latest()->paginate('10');
                      //$commandes = retreiveInfoFournisseurProduit($request->etat,$request->fournisseur);
                      return view('adminpages.commandefournisseur.cosultcommandefournisseur',compact('commandes','user','tableau','fournisseurs'));
    }

    public function afficherRecherches(Request $request){
        //dd($request->input());
        if ($request->fournisseur == "Veuillez Sélectionner" || $request->etat == "Veuillez Sélectionner" || $request->numerocomande == "Veuillez Sélectionner" || $request->numerocomande == "Veuillez Sélectionner un numero commande") {
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
        $request->session()->put('keynumerocommande',$request->numerocomande);
        $uuid = $data->uuid;
        $commandes = DB::table('fournisseur_produit')
            ->join('fournisseurs','fournisseur_produit.fournisseur_id','=','fournisseurs.id')
            ->join('produits','fournisseur_produit.produit_id','=','produits.id')
            ->where('fournisseur_produit.commandé','=',$request->etat)
            ->where('fournisseur_produit.fournisseur_id','=',$request->fournisseur)
            ->where('fournisseur_produit.numeroCommande','=',$request->numerocomande)
            ->select('fournisseur_produit.user_id as idfourniproduserId',
                     'fournisseur_produit.fournisseur_id as idfourniprodfourniId',
                     'fournisseur_produit.produit_id as idfourniprodproId',
                     'fournisseur_produit.uuid as uuidfourniprod',
                     'fournisseur_produit.dateCommande as datefourniprod',
                     'fournisseur_produit.quantiteCommande as quantitefourniprod',
                     'fournisseur_produit.quantiteLivraison as quantiteLivraison',
                     'fournisseur_produit.numeroCommande as numeroCommande',
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
        $commandeencours = retreiveInfoFournisseurProduit($request->session()->get('keye'),$request->session()->get('keyf'),session()->get('keynumerocommande'));
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

    public function fetchProduitQuantiteCommandee(Request $request)
    {
        $value = $request->get('value');
        if (isset($value)) {
            $produit = DB::table('fournisseur_produit')->where('produit_id',$value)->first();
            if ($produit) {
                return response()->json($produit);
            } else {
                return response()->json(['error' => 'Produit non trouvé'], 404);
            }
        } else {
            return response()->json(['error' => 'Valeur manquante'], 400);
        }
    }

   public function retreiveInformationsFournisseurProduit(){
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,39);
        //dd($uuid);
        $today = Carbon::now();
        /*$commandes = DB::table('fournisseur_produit')
                   ->where('fournisseur_produit.uuid','=',$uuid)->first();
        dd($commandes); */ 
        DB::update('update  fournisseur_produit 
              set 
              updated_at = ?, 
              commandé = ?,
              user_id = ?,
              livré = ?
              where uuid = ? ', 
              [
                  $today,
                  "annulé",
                  Auth::user()->id,
                  "livre_en_partie",
                  $uuid
                ]);    
                return back()->with('success','Votre annulation du reste de  commande  a été faite avec succès');                  

        
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
      $somme = 0;
      $etatCommande ="";
      $etatLivre ="";
      $montantDefeinitiPaye = 0;
      $produit = $request->item_produit;
      $quantite = $request->item_quantitelivree;
      $quantiteDefectueuses = $request->item_quantitedefectuese;
      $prix = $request->item_prixlivraison;
      $idFournisseur = $request->session()->get('keyf');
      $cmd = DB::table('fournisseur_produit')->where([
          ['fournisseur_id','=',$idFournisseur],
          ['numeroCommande','=',session()->get('keynumerocommande')]
          ]
          )->take(1)
          ->get();
          session(['cmds' => $cmd]);
          $idEtat = $request->session()->get('keye');
          for ($i = 0; $i < count($produit); $i++) {
             
            if(retreiveQuantiteCommandeFournisseurProduit($produit[$i],$request->session()->get('keyf'),session()->get('keynumerocommande'))==$quantite[$i]){
                $etatCommande = "livré";
                $etatLivre = "livré";
              }elseif(retreiveQuantiteCommandeFournisseurProduit($produit[$i],$request->session()->get('keyf'),session()->get('keynumerocommande'))!=$quantite[$i] && $quantiite[$i] >0){
                $etatCommande = "en_cours";
                $etatLivre = "livre_en_partie";
              }else{
                $etatCommande = "en_cours";
                $etatLivre = "pas_encore";
              }
              
              DB::update('update  fournisseur_produit 
              set quantiteLivraison = ?,
              dateLivraison = ?, 
              updated_at = ?, 
              prixLivraison = ?, 
              commandé = ?,
              quantitedefectuese = ?,
              user_id = ?,
              livré = ?
              where produit_id = ? and numeroCommande = ?', 
              [
                  $quantite[$i],
                  $today,
                  $today,
                  $prix[$i],
                  $etatCommande,
                  $quantiteDefectueuses[$i],
                  Auth::user()->id,
                  $etatLivre,
                  $produit[$i],session()->get('keynumerocommande')
                ]);
                $stok = Stock::where('produit_id','=', $produit[$i])->first();
                if(empty($stok)){
                    //dd('ok');
                    
                    $tableau = [
                        'user_id' => Auth::user()->id,
                        'produit_id' => $produit[$i],
                        'quantité' => $quantite[$i],
                        /*'quantiteSeuil' => $request->quantiteSeuil,
                        'quantiteAlert' => $request->quantiteAlerte,*/
                        'created_at' => $today,
                        'updated_at' => $today
                    ];
                    DB::table('stocks')->insertGetId($tableau);
                }else{
                    //dd('ok');               
                    $stk = Stock::find($stok->id);
                    $stk->user_id = Auth::user()->id;
                    $stk->quantité = $stk->quantité+$quantite[$i];
                    /*if($request->quantiteSeuil!=""){
                        $stk->quantiteSeuil = $request->quantiteSeuil;
                        }
                        if($request->quantiteAlerte!=""){
                            $stk->quantiteAlert = $request->quantiteAlerte;
                            }*/
                            $stk->updated_at = $today;
                            $stk->save();
                        }   
                        $somme+= $quantite[$i]*$prix[$i];             
                    }   
                    //dd($somme);
                    $image = $request->file('fichier');
                    $my_image = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move($_SERVER['DOCUMENT_ROOT'] . '/upload', $my_image);
                    $reglement = new Reglement;
                    $reglement->natureReglement = $request->nature;
                    $reglement->user_id = Auth::user()->id;
                    $reglement->uuid = (string)Str::uuid(); 
                    $reglement->preuve = $my_image;
                    if(isset($request->remise)){
                        
                        $reglement->remise = $request->remise;
                        $montantDefeinitiPaye = $somme - $somme*$request->remise;
                    }
                    /*if($request->livraison=="payée"){
                        
                        $reglement->montantLivraison = $request->montantLivraison;
                        $montantDefeinitiPaye += $request->montantLivraison;
                    }
                    dd($request->montantLivraison);*/
                    $reglement->montantTotal = $somme;
                    $reglement->montantDefinitifPaye = $montantDefeinitiPaye;
                    $query = $reglement->save();
                    $insertedId = $reglement->id; 
                    $livraison = new Livraison;
                    $livraison->user_id = Auth::user()->id;
                    $livraison->uuid = (string)Str::uuid(); 
                    $livraison->reglement_id = $insertedId; 
                    $livraison->numeroCommande = session()->get('keynumerocommande'); 
                    $livraison->save();

                    
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
           ->where('fournisseur_produit.numeroCommande','=',session()->get('keynumerocommande'))
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
