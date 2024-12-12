<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Forme;
use App\Models\Famille;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des produits',
            'table' => 'Produits'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $produits = DB::table('produits')
                ->join('familles','produits.famille_id','familles.id')
                ->join('formes','produits.forme_id','formes.id')
                ->where([
                    ['produits.worked','=', 1],
                    ['familles.worked','=',1],
                    ['formes.worked','=',1]
                 ])
                ->select('produits.*')->latest()->paginate('10');
                //dd($produits);
                return view('adminpages.produit.indexproduit',compact('produits','user','tableau'));   

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer les produits',
            'table' => 'Produits'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $formes = Forme::where('worked','=',1)->get();
                $familles = Famille::where('worked','=',1)->get();
                return view('adminpages.produit.createproduit',compact('formes','familles','user','tableau'));   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->famille == "Veuillez Selectionner" || $request->forme == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs famille, ou forme');
        }

        if($request->quantiteSeuil<$request->quantiteStock){
            return back()->with('errorchamps', 'Echec!!!la quantite seuil doit être plus grande que la quantité alerte');
        }
        $request->validate([
            'nom' => 'required|min:4|unique:produits',
            'description' => 'required|min:4',
            'quantiteStock' => 'required|numeric',
            'quantiteSeuil' => 'numeric',
            'famille' => 'required',
            'forme' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $produit = new Produit;
            $produit->uuid = (string)Str::uuid();
            $produit->user_id = Auth::user()->id;
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->quantiteStock = $request->quantiteStock;
            $produit->quantiteSeuil = $request->quantiteSeuil;
            $produit->famille_id = $request->famille;
            $produit->forme_id = $request->forme;
            $produit->worked = 1;
            $query = $produit->save();
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
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $tableau = [
            'liste' => 'Modification produit',
            'table' => 'Produits'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,14); 
            //dd($uuid);
            $formes = Forme::where('worked','=',1)->get();
            $familles = Famille::where('worked','=',1)->get();
            $produit = Produit::where('uuid',$uuid)->first();
            $famId = $produit['famille_id'];
            $formId = $produit['forme_id'];
            return view('adminpages.produit.editproduit',compact('famId','formId','formes','familles','user','produit','tableau')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        if ($request->famille == "Veuillez Selectionner" || $request->forme == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs famille, ou forme');
        }

        if($request->quantiteSeuil<$request->quantiteStock){
            return back()->with('errorchamps', 'Echec!!!la quantite seuil doit être plus grande que la quantité alerte');
        }
        $request->validate([
            'nom' => 'required',
            'description' => 'required|min:4',
            'quantiteStock' => 'required',
            'quantiteSeuil' => 'required',
            'famille' => 'required',
            'forme' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $produit =  Produit::find($request->id);
            $produit->user_id = Auth::user()->id;
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->quantiteStock = $request->quantiteStock;
            $produit->quantiteSeuil = $request->quantiteSeuil;
            $produit->famille_id = $request->famille;
            $produit->forme_id = $request->forme;
            $query = $produit->save();
            if($query){
               return redirect()->route('produit.index')->with('success','Votre modification a été fait avec succès'); 
            }
            DB::commit();
           }catch (\Throwable $e) {
                    DB::rollback();
                    throw $e;
                }  
        
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        //
    }

    public function imprime(){
        $user = User::where('id', '=', Auth::user()->id)->first();
        $data = [
            'produits' => Produit::where('worked','=',1)->get()
        ];
        
        $pdf = Pdf::loadView('imprimeetatproduitpdf',$data);
        return $pdf->download('imprimeetatproduitpdf.pdf');
        
      }
}
