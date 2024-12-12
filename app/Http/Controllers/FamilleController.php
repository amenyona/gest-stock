<?php

namespace App\Http\Controllers;

use App\Models\Famille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class FamilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des familles',
            'table' => 'Familles'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $familles = Famille::where('worked','=',1)->latest()->paginate('10');
                return view('adminpages.famille.indexfamille',compact('familles','user','tableau'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer  famille',
            'table' => 'Familles'
            ];

           $user = User::where('id', '=', Auth::user()->id)->first();
           return view('adminpages.famille.createfamille',compact('user','tableau')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|min:4|unique:familles',
            'description' => 'required|min:4'
        ]);
        DB::beginTransaction();
        try{
            $famille = new Famille;
            $famille->uuid = (string)Str::uuid();
            $famille->user_id = Auth::user()->id;
            $famille->nom = $request->nom;
            $famille->worked = 1;
            $famille->description = $request->description;
            $query = $famille->save();
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
    public function show(Famille $famille)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Famille $famille)
    {
        $tableau = [
            'liste' => 'Modification famille',
            'table' => 'Familles'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,14); 
            //dd($uuid);
            $famille = Famille::where('uuid',$uuid)->first();
              return view('adminpages.famille.editfamille',compact('user','famille','tableau'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Famille $famille)
    {
        ///dd($request->input());
        $request->validate([
            'nom' => 'required|min:4',
            'description' => 'required|min:4'
            ]);  
             $url = $_SERVER['REQUEST_URI'];
             $uuid = substr($url,16); 
             //dd($uuid);
             DB::beginTransaction();

            try {

                $famille = Famille::find($request->id);
                $famille->nom = $request->nom;
                $famille->description = $request->description;
                $famille->save();
                return redirect()->route('famille.index')->with('success','La famille a été modifiée avec succès');
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }         
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Famille $famille)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,15);
        //dd($uuid);
        $fam = Famille::where('uuid', $uuid)->first();
        //dd($fam->id);
        $famille = Famille::find($fam->id);
        $famille->worked = 0;
        $famille->save();

        return redirect()->route('famille.index')->with('success','La famille des produits a été supprimée avec succès');
    }

    public function imprimeFournisseur(){
        $user = User::where('id', '=', Auth::user()->id)->first();
        $data = [
           'familles' => Famille::where('worked','=',1)->get()
       ];
        
        $pdf = Pdf::loadView('imprimeetatfamillespdf',$data);
        return $pdf->download('imprimeetatfamillespdf.pdf');
        
      }

      public function fetchFamilleForme(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $query = Famille::find($value)->formes()->get();;
        $output = '<option value="">Sélectionner une '.$dependent.'</option>';
        foreach($query as $row){
            $output .= '<option value="'.$row->id.'">'.$row->nom.'</option>';
        }
        echo $output;
        
    }
}
