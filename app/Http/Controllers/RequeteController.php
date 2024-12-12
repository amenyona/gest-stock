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

class RequeteController extends Controller
{

  public function requeteFiche(){
    $tableau = [
        'liste' => 'Liste des produits dont la quantité est inférieure à un seuil',
        'table' => 'Stocks'
        ];
    $alertes = DB::table('stocks')->select('quantiteAlert','id')->get();
    $seuils = DB::table('stocks')->select('quantiteSeuil','id')->get();
    $user = User::where('id', '=', Auth::user()->id)->first();
    return view('adminpages.requete.requetefiche', compact('tableau','user','alertes','seuils'));
  }
   public function rechercherStockAlert(Request $request)
   {
    //dd($request->alerte);
    //dd('ok');
    $stock = Stock::limit('1')->get();
    //dd($stock[0]->quantiteAlert);
    $alerte = $stock[0]->quantiteAlert;
    $tableau = [
        'liste' => 'Liste des produits dont la quantité est inférieure à un seuil',
        'table' => 'Stocks'
        ];
    $user = User::where('id', '=', Auth::user()->id)->first();
    $stocks = Stock::where('quantité','<',$alerte)->latest()->simplePaginate(10);
    //dd($stocks);
    //session('alertestocks',$alertestocks);
    //session(['keyAlertestocks' => $stocks]);
    return view('adminpages.requete.alerte', compact('tableau','user','stocks'));
   }
   public function imprimeAlert(){
    $stock = Stock::limit('1')->get();
    //dd($stock[0]->quantiteAlert);
    $alerte = $stock[0]->quantiteAlert;
     $stocksAlerts = [
        'stocks' =>  Stock::where('quantité','<',$alerte)->get()
    ];
    
     $pdf = Pdf::loadView('imprimeetatalertpdf',$stocksAlerts);
     return $pdf->download('imprimeetatalertpdf.pdf');
     
   }
   
   public function rechercherStockSeuil(Request $request)
   {
       //dd($request->alerte);
       //dd('ok');
       $stock = Stock::limit('1')->get();
       //dd($stock[0]->quantiteAlert);
       if(count($stock)>0){
        
           $seuil = $stock[0]->quantiteSeuil;
           $tableau = [
               'liste' => 'Liste des produits dont la quantité est inférieure à un seuil',
               'table' => 'Stocks'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $stocks = Stock::where('quantité','<',$seuil)->latest()->simplePaginate(10);;
            //dd($stocks);
            //session(['keySeuilstocks' => $stocks]);
            return view('adminpages.requete.seuil', compact('tableau','user','stocks'));
       }else{
        return back()->with('errorchamps', 'Echec!!!vous n\'avez pas de données disponibles');
       }
    }
    public function imprimeSeuil(){
      $stock = Stock::limit('1')->get();
       //dd($stock[0]->quantiteAlert);
      $seuil = $stock[0]->quantiteSeuil;
      $stocksSeuils = [
         'stocks' =>Stock::where('quantité','<',$seuil)->get()
     ];
      
      $pdf = Pdf::loadView('imprimeetatseuilpdf',$stocksSeuils);
      return $pdf->download('imprimeetatseuilpdf.pdf');
      
    }
   public function stockAlert(Request $request)
   {
    $tableau = [
        'liste' => 'Liste des produits dont la quantité est inférieure à un seuil',
        'table' => 'Stocks'
        ];
    $user = User::where('id', '=', Auth::user()->id)->first();
    $stocksAlerts = DB::table('stocks')
                   ->join('produits','stocks.produit_id','=','produits.id')
                   ->where('stocks.quantité','<=',$request->alerte)
                   ->get();
    dd($stocksAlerts);
    return view('adminpages.requete.seuilinferieur', compact('tableau','user','stocksAlerts'));
   }

   public function stockInferieurSeuil($seuil)
   {
    $tableau = [
        'liste' => 'Liste des produits dont la quantité est inférieure à un seuil',
        'table' => 'Stocks'
        ];
    $user = User::where('id', '=', Auth::user()->id)->first();
    $stocksAlerts = DB::table('stocks')
    ->where('quantité', '<', $seuil)
    ->latest()->paginate('10');
    return view('adminpages.requete.seuilinferieur', compact('tableau','user','stocksAlerts'));
   }


}
