<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\User;
use App\Models\Stock;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des ventes',
            'table' => 'Ventes'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $ventes = DB::table('produit_vente')
        ->join('ventes','produit_vente.vente_id','=','ventes.id')
        ->join('produits','produit_vente.produit_id','=','produits.id')
        ->select('produit_vente.user_id as idCreateur',
                 'produit_vente.vente_id as idVente',
                 'produit_vente.produit_id as idProd',
                 'produit_vente.uuid as uuidProdVente',
                 'produit_vente.ordonnaceId as ordonnaceVente',
                 'produit_vente.quantité_vendue as quantiteVendue',
                 'produit_vente.prix_unitaire as prixUnitaireProdVente',
                 'produit_vente.worked as workedProdVente',
                 'produit_vente.created_at as created_at',
                 'produit_vente.updated_at as updated_at',
                 'produit_vente.id as pivotId',
                 'produits.nom as produitnom',
                 'ventes.dateVente as dateVente'
                  )
                  ->orderBy('created_at','DESC')
                  ->latest()->paginate('10');
        return view('adminpages.vente.indexvente', compact('user','ventes','tableau'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer des ventes',
            'table' => 'Ventes'
            ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        return view('adminpages.vente.createvente', compact('user','tableau'));
    }

    
public function fetchProduitPrix(Request $request)
{
    $value = $request->get('value');
    if (isset($value)) {
        $produit = Produit::find($value);
        if ($produit) {
            return response()->json($produit);
        } else {
            return response()->json(['error' => 'Produit non trouvé'], 404);
        }
    } else {
        return response()->json(['error' => 'Valeur manquante'], 400);
    }
}




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $res = array();
      //dd($request->input());
      $today = Carbon::now();
      $produit = $request->item_produitv;
      $quantite = $request->item_quantitev;
      $prix = $request->item_prixunitairev;
      $vente = new Vente;
      $vente->user_id = Auth::user()->id;
      $vente->uuid = (string)Str::uuid();
      $vente->dateVente = $today;
      $vente->worked = 1;
      $vente->save();
      $idVenteEnreng = $vente->id;

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
            'prix_unitaire' => $prix[$i],
            'created_at' => $today,
            'updated_at' => $today,               
            'worked' => 1,               
        ];
        $res [] = [
            'user_id' => Auth::user()->id,
            'uuid' => (string)Str::uuid(),
            'produit_id' => $produit[$i],
            'vente_id' => $idVenteEnreng,
            'quantité_vendue' => $quantite[$i],
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

    //dd($res);
        $data = [
           'ventes' =>$res
       ];
        
        $pdf = Pdf::loadView('imprimeetatventepdf',$data);
         return $pdf->stream();
        //return $pdf->download('imprimeetatfournisseurspdf.pdf');
    //return back()->with('success', 'La vente a été effectuée avec succès!');
    }

 public function getTodayVente(Request $request){
    $ventes = Vente::whereDate('created_at', Carbon::today())->get();
    $ventes = Sale::whereBetween('created_at', [$startDate, $endDate])->get();
    return $ventes;
 }


    /**
     * Display the specified resource.
     */
    public function show(Vente $vente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vente $vente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        //
    }
}
