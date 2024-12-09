<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des patients',
            'table' => 'Patients'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $patients = Patient::where('worked','=',1)->latest()->paginate('10');
                return view('adminpages.patient.indexpatient',compact('patients','user','tableau'));   

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $tableau = [
            'liste' => 'Créer des patients',
            'table' => 'Patients'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                return view('adminpages.patient.createpatient',compact('user','tableau'));   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:patients',
            'telephone' => 'required|min:8|unique:patients',

        ]);
       //dd($request->input());
        DB::beginTransaction();
        try{
            $patient = new Patient;
            $patient->uuid = (string)Str::uuid();
            $patient->user_id = Auth::user()->id;
            $patient->nom = $request->nom;
            $patient->prenom = $request->prenom;
            $patient->telephone = $request->telephone;
            $patient->email = $request->email;
            $patient->worked = 1;
            $query = $patient->save();
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
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $tableau = [
            'liste' => 'Modifier patient',
            'table' => 'Patients'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,18); 
            //dd($uuid);
            $patient = Patient::where('uuid',$uuid)->first();
            //dd($patient['id']);
            return view('adminpages.patient.editpatient',compact('user','patient','tableau'));  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
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
                    $patient = Patient::find($request->idpatient);
                    //dd($patient);
                    $patient->user_id = Auth::user()->id;
                    $patient->nom = $request->nom;
                    $patient->prenom = $request->prenom;
                    $patient->telephone = $request->telephone;
                    $patient->email = $request->email;
                    $query = $patient->save();
                    if($query){
                       return redirect()->route('patient.liste')->with('success','Votre modification a été faite avec succès'); 
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
    public function destroy(Patient $patient)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,16);
        //dd($uuid);
        $patient = Patient::where('uuid', $uuid)->first();
        //dd($patient);
        $patient = Patient::find($patient['id']);
        $patient->worked = 0;
        $patient->save();

        return redirect()->route('patient.liste')->with('success','Le médecin a été supprimé avec succès');

    }
}
