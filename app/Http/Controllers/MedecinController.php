<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des medecins',
            'table' => 'Medecins'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $medecins = Medecin::where('worked','=',1)->latest()->paginate('10');
                return view('adminpages.medecin.indexmedecin',compact('medecins','user','tableau'));   

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableau = [
            'liste' => 'Créer des medecins',
            'table' => 'Medecins'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                return view('adminpages.medecin.createmedecin',compact('user','tableau'));   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:medecins',
            'telephone' => 'required|min:8|unique:medecins',

        ]);
       //dd($request->input());
        DB::beginTransaction();
        try{
            $medecin = new Medecin;
            $medecin->uuid = (string)Str::uuid();
            $medecin->user_id = Auth::user()->id;
            $medecin->nom = $request->nom;
            $medecin->prenom = $request->prenom;
            $medecin->telephone = $request->telephone;
            $medecin->email = $request->email;
            $medecin->worked = 1;
            $query = $medecin->save();
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
    public function show(Medecin $medecin)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medecin $medecin)
    {
        $tableau = [
            'liste' => 'Modifier médecin',
            'table' => 'Médecins'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,18); 
            //dd($uuid);
            $medecin = Medecin::where('uuid',$uuid)->first();
            //dd($medecin['id']);
            return view('adminpages.medecin.editmedecin',compact('user','medecin','tableau'));  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medecin $medecin)
    {
        //dd($request->input());
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'telephone' => 'required|min:8',

        ]);
       
        DB::beginTransaction();
        try{
            $medecin = Medecin::find($request->idmedecin);
            //dd($medecin);
            $medecin->user_id = Auth::user()->id;
            $medecin->nom = $request->nom;
            $medecin->prenom = $request->prenom;
            $medecin->telephone = $request->telephone;
            $medecin->email = $request->email;
            $query = $medecin->save();
            if($query){
               return redirect()->route('medecin.liste')->with('success','Votre modification a été faite avec succès'); 
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
    public function destroy(Medecin $medecin)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,16);
        //dd($uuid);
        $medecin = Medecin::where('uuid', $uuid)->first();
        //dd($medecin);
        $medecin = Medecin::find($medecin['id']);
        $medecin->worked = 0;
        $medecin->save();

        return redirect()->route('medecin.liste')->with('success','Le médecin a été supprimé avec succès');
    }
}
