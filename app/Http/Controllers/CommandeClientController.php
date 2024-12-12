<?php

namespace App\Http\Controllers;

use App\Models\CommandeClient;
use App\Models\User;
use App\Models\Client;
use App\Models\Vente;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CommandeClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer des commandes client',
            'table' => 'Commandes client'
            ];
            
        $user = User::where('id', '=', Auth::user()->id)->first();
        $clients = Client::where('worked','=',1)->get();
        return view('adminpages.commandeclient.createcommandeclient',compact('user','tableau','clients'));   

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->input());
      $request->validate([
        'client' => 'required',
        'dateprescription' => 'required',
        
    ]);
    //dd($request->input());
      if ($request->client == "Veuillez Selectionner") {
        return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs medecin et patient');
    }
      $today = Carbon::now();
      $produit = $request->item_produitv;
      $quantite = $request->item_quantitev;
      $prix = $request->item_prixunitairev;
      $image = $request->file('fichier');
      $my_image = rand() . '.' . $image->getClientOriginalExtension();
      $image->move($_SERVER['DOCUMENT_ROOT'] . '/upload', $my_image);
        /**Enregistrement de la vente */
      $vente = new Vente;
      $vente->user_id = Auth::user()->id;
      $vente->uuid = (string)Str::uuid();
      $vente->dateVente = $today;
      $vente->worked = 1;
      $vente->save();
      $idVenteEnreng = $vente->id;
      /**-------Fin de la création de la vente */
      /**Enregistrement de l'ordonnacne */
      $commandeClient = new CommandeClient;
      $commandeClient->fiche = $my_image;
      $commandeClient->user_id = Auth::user()->id;
      $commandeClient->uuid = (string)Str::uuid(); 
      $commandeClient->worked = 1; 
      $commandeClient->save();
      $insertedIdord = $commandeClient->id;
        /**-------Fin de la création de l'ordonnance */ 
        /**Création ligne ordonnance */
        $dataSave = [
            
            'uuid' => (string)Str::uuid(),
            'client_id' => $request->medecin,
            'commandeClient_id' => $idVenteEnreng,
            'datePrescription' => $request->dateprescription,
            'dateEnregistrement' => $today,
            'created_at' => $today,
            'updated_at' => $today,               
            'worked' => 1,               
        ];
        $idMdop = DB::table('client_produit')->insertGetId($dataSave);
        /**-------Fin de la création de la ligne ordonnance */ 
      /**Création de la vente et de la ligne de vente */
        for ($i = 0; $i < count($produit); $i++) {
            $stok = Stock::where('produit_id','=', $produit[$i])->first();
            if(!empty($stok)){
            $stk = Stock::find($stok->id);
            if($quantite[$i] >$stk->quantité ){
                return back()->with('errorchamps', 'Echec!!!Veuillez revoir les quantités saisies elles ne sont pas correctes!');
             }
            $dataSave = [
                'user_id' => Auth::user()->id,
                'uuid' => (string)Str::uuid(),
                'produit_id' => $produit[$i],
                'vente_id' => $idVenteEnreng,
                'quantité_vendue' => $quantite[$i],
                'commandeClient_id' => $idMdop,
                'prix_unitaire' => $prix[$i],
                'created_at' => $today,
                'updated_at' => $today,               
                'worked' => 1,               
            ];
            
            //DB::table('documents')->insert($dataSave);
            DB::table('produit_vente')->insertGetId($dataSave);
           
             //dd('ok');               
             
             $stk->quantité = $stk->quantité-$quantite[$i];         
             $stk->updated_at = $today;
             $stk->save();
            }                   
    
    
    }
    return back()->with('success', 'La vente a été effectuée avec succès!');

}
        /**-------Fin de la création de la vente et de la ligne de vente */ 


    /**
     * Display the specified resource.
     */
    public function show(CommandeClient $commandeClient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommandeClient $commandeClient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommandeClient $commandeClient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommandeClient $commandeClient)
    {
        //
    }
}
