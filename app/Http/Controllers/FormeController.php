<?php

namespace App\Http\Controllers;

use App\Models\Forme;
use App\Models\Famille;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FormeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des formes',
            'table' => 'Formes'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $formes = Forme::where('worked','=',1)->latest()->paginate('10');
                return view('adminpages.forme.indexforme',compact('formes','user','tableau'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  forme',
            'table' => 'Formes'
            ];

          $familles = Famille::where('worked','=',1)->get();
          $user = User::where('id', '=', Auth::user()->id)->first();
          return view('adminpages.forme.createforme',compact('user','tableau','familles')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|min:4|unique:formes',
            'description' => 'required|min:4'
        ]);
        if($request->familles==="Veuillez Sélectionner"){
            return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner la famille de produits');
        } 
        DB::beginTransaction();
        try{
            $forme = new Forme;
            $forme->uuid = (string)Str::uuid();
            $forme->user_id = Auth::user()->id;
            $forme->famille_id = $request->familles;
            $forme->nom = $request->nom;
            $forme->worked = 1;
            $forme->description = $request->description;
            $query = $forme->save();
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
    public function show(Forme $forme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forme $forme)
    {
        $tableau = [
            'liste' => 'Modification forme',
            'table' => 'Formes'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,12); 
            //dd($uuid);
            $familles = Famille::where('worked','=',1)->get();
            $forme = Forme::where('uuid',$uuid)->first();
            //dd($forme);
              return view('adminpages.forme.editforme',compact('user','forme','tableau','familles'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forme $forme)
    {
        $request->validate([
            'nom' => 'required|min:4',
            'description' => 'required|min:4'
            ]);
            if($request->familles==="Veuillez Sélectionner"){
                return back()->with('errorchamps', 'Echec!!! Veuillez sélectionner la famille de produits');
            } 
             $url = $_SERVER['REQUEST_URI'];
             $uuid = substr($url,16); 
             //dd($uuid);
             DB::beginTransaction();

            try {

                $forme = Forme::find($request->id);
                $forme->nom = $request->nom;
                $forme->famille_id = $request->familles;
                $forme->description = $request->description;
                $forme->save();
                return redirect()->route('forme.index')->with('success','La forme a été modifiée avec succès');
                DB::commit();

            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }         

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forme $forme)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,13);
        //dd($uuid);
        $fam = Forme::where('uuid', $uuid)->first();
        //dd($fam->id);
        $forme = Forme::find($fam->id);
        $forme->worked = 0;
        $forme->save();

        return redirect()->route('forme.index')->with('success','La forme a été supprimée avec succès');
    }

    public function imprime(){
        $user = User::where('id', '=', Auth::user()->id)->first();
        $data = [
            'formes' => Forme::where('worked','=',1)->get()
        ];
        
        $pdf = Pdf::loadView('imprimeetatformespdf',$data);
        return $pdf->download('imprimeetatformespdf.pdf');
        
      }
}
