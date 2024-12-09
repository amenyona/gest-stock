<?php

namespace App\Http\Controllers;

use App\Models\Ordonnance;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Vente;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrdonnanceController extends Controller
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
            'liste' => 'Créer des ordoannaces',
            'table' => 'Ordonnances'
            ];
            
        $user = User::where('id', '=', Auth::user()->id)->first();
        $medecins = Medecin::where('worked','=',1)->get();
        $patients = Patient::where('worked','=',1)->get();
        return view('adminpages.ordonnance.createordonnance',compact('user','tableau','medecins','patients'));   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //dd($request->input());
      $request->validate([
        'patient' => 'required',
        'medecin' => 'required',
        'dateprescription' => 'required',
        
    ]);
    //dd($request->input());
      if ($request->patient == "Veuillez Selectionner" || $request->medecin == "Veuillez Selectionner") {
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
      $ordonnance = new Ordonnance;
      $ordonnance->fiche = $my_image;
      $ordonnance->user_id = Auth::user()->id;
      $ordonnance->uuid = (string)Str::uuid(); 
      $ordonnance->worked = 1; 
      $ordonnance->save();
      $insertedIdord = $ordonnance->id;
        /**-------Fin de la création de l'ordonnance */ 
        /**Création ligne ordonnance */
        $dataSave = [
            
            'uuid' => (string)Str::uuid(),
            'medecin_id' => $request->patient,
            'patient_id' => $request->medecin,
            'ordonnance_id' => $idVenteEnreng,
            'datePrescription' => $request->dateprescription,
            'dateEnregistrement' => $today,
            'created_at' => $today,
            'updated_at' => $today,               
            'worked' => 1,               
        ];
        $idMdop = DB::table('medecin_ordonnance_patient')->insertGetId($dataSave);
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
                'ordonnaceId' => $idMdop,
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
        /**-------Fin de la création de la vente et de la ligne de vente */ 
        
        return back()->with('success', 'La vente a été effectuée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ordonnance $ordonnance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordonnance $ordonnance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordonnance $ordonnance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordonnance $ordonnance)
    {
        //
    }
}
