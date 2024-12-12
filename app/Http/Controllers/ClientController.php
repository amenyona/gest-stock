<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste des Clients',
            'table' => 'Clients'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                $clients = Client::where('worked','=',1)->latest()->paginate('10');
                return view('adminpages.client.indexClient',compact('clients','user','tableau'));   

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $tableau = [
            'liste' => 'Créer des Clients',
            'table' => 'Clients'
            ];
            
                $user = User::where('id', '=', Auth::user()->id)->first();
                return view('adminpages.client.createClient',compact('user','tableau'));   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:Clients',
            'telephone' => 'required|min:8|unique:Clients',

        ]);
       //dd($request->input());
        DB::beginTransaction();
        try{
            $client = new Client;
            $client->uuid = (string)Str::uuid();
            $client->user_id = Auth::user()->id;
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->telephone = $request->telephone;
            $client->email = $request->email;
            $client->worked = 1;
            $query = $client->save();
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $tableau = [
            'liste' => 'Modifier Client',
            'table' => 'Clients'
            ];
  
            $user = User::where('id','=',Auth::user()->id)->first();
            $url = $_SERVER['REQUEST_URI'];
            $uuid = substr($url,18); 
            //dd($uuid);
            $client = Client::where('uuid',$uuid)->first();
            //dd($Client['id']);
            return view('adminpages.client.editClient',compact('user','client','tableau'));  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
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
            $client = Client::find($request->idClient);
            //dd($Client);
            $client->user_id = Auth::user()->id;
            $client->nom = $request->nom;
            $client->prenom = $request->prenom;
            $client->telephone = $request->telephone;
            $client->email = $request->email;
            $query = $client->save();
            if($query){
               return redirect()->route('client.liste')->with('success','Votre modification a été faite avec succès'); 
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
    public function destroy(Client $client)
    {
        $url = $_SERVER['REQUEST_URI'];
        $uuid = substr($url,16);
        //dd($uuid);
        $clientinfo = Client::where('uuid', $uuid)->first();
        //dd($Client);
        $client = Client::find($clientinfo['id']);
        $client->worked = 0;
        $client->save();

        return redirect()->route('client.liste')->with('success','Le client a été supprimé avec succès');

    }
}
