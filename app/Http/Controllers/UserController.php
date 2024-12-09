<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\AnneeAcademique;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableau = [
            'liste' => 'Liste Des Pays',
            'table' => 'Pays'
            ];
        $users = User::latest()->paginate('10');
        $user = User::where('id', '=', Auth::user()->id)->first();
                //dd($pays);
        return view('auth.index',compact('users','tableau','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('isAdmin')){
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $roles = Role::where('name','<>','eleve')->get();
            return view('auth.register', compact('roles', 'tableau','user'));

        }
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->role == "Veuillez Selectionner" || $request->sexe == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
        }
        $request->validate([
            'role' => 'required',
            'lastname' => 'required|min:4',
            'firstname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:8',
            'sexe' => 'required',
            'password' => 'required|min:8|max:12',
            'new_confirm_password' => 'required_with:password|same:password|min:8|max:12',
        ]);

        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];
        
        DB::beginTransaction();
        try {
            //dd($request->input());
            $request->session()->put('key',$request->firstname);
            $value = $request->session()->get('key');
            
            //dd($value);
            $user1 = new User;
            $user1->uuid = (string)Str::uuid();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user1->user_creator_id = Auth::user()->id;
            $user1->name = $request->lastname;
            $user1->firstname = $request->firstname;
            $user1->phone = $request->phone;
            $user1->email = $request->email;
            $user1->sexe = $request->sexe;
            $user1->online = "oui";
            $user1->password = Hash::make($request->password);
            $query = $user1->save();
            $insertedId = $user1->id;
           

            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$request->role, $insertedId]);
            /*Mail::to("late@pushtudio.com")->bcc("amenyona.late@gmail.com")
						->send(new MessageGoogle("premier test"));*/
            if ($query) {
                return redirect()->route(('user.create'))->with('success', 'Votre enregistrement s\'est fait avec succes!!!');
            } else {
                return back()->with('error', 'Echec lors de l\'enregistrement. Veuillez refaire!!!');
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function inscrire(){
        if(Gate::allows('isAdmin')){
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];
            $user = User::where('id', '=', Auth::user()->id)->first();
            $roletuteurs = Role::where('name','=','Tuteur/Parent')->get();
            return view('auth.inscrirebegin', compact('roletuteurs', 'tableau','user'));

        }
    }

    public function processInscrire(Request $request){
        if(Gate::allows('isAdmin')){
            if ($request->role == "Veuillez Selectionner" || $request->sexe == "Veuillez Selectionner") {
                return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
            }
           //dd($request->role);
           $request->validate([
                'role' => 'required',
                'lastname' => 'required|min:4',
                'firstname' => 'required|min:4',
                'email' => 'required|email|unique:users',
                'phone' => 'required|min:8',
                'sexe' => 'required',
                ]); 
           
            $tableau = [
                'liste' => 'Créer Des Utilisateurs',
                'table' => 'Utilisateurs'
            ];

            $tablo = [
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'phone' => $request->phone,
                'email' => $request->email,
                'sexe' => $request->sexe,
                'online' => "oui",
                
            ];

            $user = User::where('id', '=', Auth::user()->id)->first();
            $roles = Role::where('name','=','Elève')->get();
            
            $request->session()->put('keylastname', $request->lastname);
            $request->session()->put('keyfirstname', $request->firstname);
            $request->session()->put('keyphone', $request->phone);
            $request->session()->put('keyemail', $request->email);
            $request->session()->put('keysexe', $request->sexe);
            $request->session()->put('keyrole', $request->role);
            

            

            session(['rols' => $roles]);
            return view('auth.inscription')->with([ 
                'roles' => $roles,
                'tableau' => $tableau,
                'user'  => $user,
                ]);
            

        }

    }
    

    public function finishInscription(Request $request){
        if ($request->roleeleve == "Veuillez Selectionner" || $request->sexeeleve == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, ou sexe');
        }
        if(retreiveEmail($request->emaileleve)){
            return back()->with('errorchamps', 'cet adresse existe déjà!!!Veuillez revérifier');
        }
        $request->validate([
            'roleeleve' => 'required',
            'lastnameeleve' => 'required|min:4',
            'firstnameeleve' => 'required|min:4',
            //'emaileleve' => 'required|email|unique:users',
            'phoneeleve' => 'required|min:8',
            'sexeeleve' => 'required',
            
        ]); 
        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];
        $user = User::where('id', '=', Auth::user()->id)->first();
        $roles = Role::where('name','=','Elève')->get();
        $roletuteurs = Role::where('name','=','Tuteur/Parent')->get();
        session(['roles' => $roles]);
        session(['roletuteurs' => $roletuteurs]);
        //dd($request->session()->get('keylastname'));
        $annees = AnneeAcademique::where('etat','=',1)->get();
        $classes = Classe::where('etat','=',1)->get();
        $request->session()->put('keylastnameeleve', $request->lastnameeleve);
        $request->session()->put('keyfirstnameeleve', $request->firstnameeleve);
        $request->session()->put('keyphoneeleve', $request->phoneeleve);
        $request->session()->put('keyemaileleve', $request->emaileleve);
        $request->session()->put('keysexeeleve', $request->sexeeleve);
        $request->session()->put('keyroleeleve', $request->roleeleve);
        return view('auth.endinscription')->with([ 
            'roletuteurs' => $roletuteurs,
            'roles' => $roles,
            'tableau' => $tableau,
            'user'  => $user,
            'classes' => $classes,
            'annees' => $annees
            ]);

    }

    public function storeinscription(Request $request)
    {


        if ($request->roleeleve == "Veuillez Selectionner" || 
            $request->sexeeleve == "Veuillez Selectionner" ||
            $request->role == "Veuillez Selectionner" ||
            $request->sexe == "Veuillez Selectionner"||
            $request->natureversement == "Veuillez Selectionner"||
            $request->annees == "Veuillez Selectionner"||
            $request->classes == "Veuillez Selectionner") {
            return back()->with('errorchamps', 
            'Echec!!!Veuillez selectionner les champs role, 
            ou sexe, ou annee académique, 
            ou nature versement, ou classe');
        }

        if(retreiveEmail($request->emaileleve)){
            return back()->with('errorchamps', 
            'cet adresse existe déjà!!!Veuillez revérifier');
        }

        if(verifFraisScolarite($request->classes, $request->annees,$request->montantpaye)){
            return redirect()->route(('user.index'))->with('errorchamps',
            'Le montant saisi est plus grand que la scolarité prévue');
        }

        $request->validate([
            'roleeleve' => 'required',
            'lastnameeleve' => 'required|min:4',
            'firstnameeleve' => 'required|min:4',
            //'emaileleve' => 'required|email|unique:users',
            'phoneeleve' => 'required|min:8',
            'sexeeleve' => 'required',
            'password' => 'required|min:8|max:12',
            'new_confirm_password' => 'required_with:password|same:password|min:8|max:12',
            'role' => 'required',
            'lastname' => 'required|min:4',
            'firstname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:8',
            'sexe' => 'required',
            'trancheVersement' => 'required|numeric',
            'passwordeleve' => 'required|min:8|max:12',
            'new_confirm_passwordeleve' => 'required_with:password|same:passwordeleve|min:8|max:12',
        ]);

        
        $tableau = [
            'liste' => 'Créer Des Utilisateurs',
            'table' => 'Utilisateurs'
        ];

        $today = Carbon::now();

        $request->session()->put('keylastname', $request->lastname);
        $request->session()->put('keyfirstname', $request->firstname);
        $request->session()->put('keyphone', $request->phone);
        $request->session()->put('keyemail', $request->email);
        $request->session()->put('keysexe', $request->sexe);
        $request->session()->put('keyrole', $request->role);
        $request->session()->put('keypassword', $request->password);
        $request->session()->put('keynew_confirm_password', $request->new_confirm_password);

        $request->session()->put('keylastnameeleve', $request->lastnameeleve);
        $request->session()->put('keyfirstnameeleve', $request->firstnameeleve);
        $request->session()->put('keyphoneeleve', $request->phoneeleve);
        $request->session()->put('keyemaileleve', $request->emaileleve);
        $request->session()->put('keysexeeleve', $request->sexeeleve);
        $request->session()->put('keyroleeleve', $request->roleeleve);
        $request->session()->put('keypasswordeleve', $request->passwordeleve);
        $request->session()->put('keynew_confirm_passwordeleve', $request->new_confirm_passwordeleve);

        
        DB::beginTransaction();
        try {
            $rs= $request->session()->get('keylastname');
            //dd($request->session()->get('keyrole'));
            $user1 = new User;
            $user1->uuid = (string)Str::uuid();
            $user = User::where('id', '=', Auth::user()->id)->first();
            $user1->user_creator_id = Auth::user()->id;
            $user1->name = $request->session()->get('keylastname');
            $user1->firstname = $request->session()->get('keyfirstname');
            $user1->phone = $request->session()->get('keyphone');
            $user1->email = $request->session()->get('keyemail');
            $user1->sexe = $request->session()->get('keysexe');
            $user1->online = "oui";
            $user1->password = Hash::make($request->session()->get('keypassword'));
            $query = $user1->save();
            $insertedId = $user1->id;
            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$request->session()->get('keyrole'), $insertedId]);
            /*Mail::to("late@pushtudio.com")->bcc("amenyona.late@gmail.com")
						->send(new MessageGoogle("premier test"));*/
            //$query = true;
            if ($query) {
             //dd($request->session()->get('keyroleeleve'));
            $user2 = new User;
            $user2->uuid = (string)Str::uuid();
            $user2->user_creator_id = Auth::user()->id;
            $user2->name = $request->session()->get('keylastnameeleve');
            $user2->firstname = $request->session()->get('keyfirstnameeleve');
            $user2->phone = $request->session()->get('keyphoneeleve');
            $user2->email = $request->session()->get('keyemaileleve');
            $user2->sexe = $request->session()->get('keysexeeleve');
            $user2->online = "oui";
            $user2->password = Hash::make($request->passwordeleve);
            $query2 = $user2->save();
            $insertedId2 = $user2->id;
            DB::insert('insert into role_user (role_id, user_id) values (?, ?)', [$request->session()->get('keyroleeleve'), $insertedId2]);
            //dd($insertedId2);
            DB::insert('insert into user_classe_academique (
            eleve_id, anneeacademique_id, classe_id, tuteur_id,
            user_creator_id,uuid, dateInscription, natureVersement,
            trancheVersement, dateTrancheVersement,statut
            ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
             [$insertedId2,$request->annees, $request->classes,$insertedId,
             Auth::user()->id, (string)Str::uuid(),$today,$request->natureversement,
            $request->montantpaye,$today,1
            ]);

            $success = "Enregistrement réussi";
            return redirect()->route(('user.index'))->with('success','L\'inscription a été faite avec success');
            } else {
            return back()->with('error', 'Echec lors de l\'enregistrement. Veuillez refaire!!!');
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $query = DB::table('eglise_pays')
                 ->join('pays','eglise_pays.pays_id','pays.id')
                 ->join('eglises','eglise_pays.eglise_id','eglises.id')
                 ->where('pays.id',$value)
                 ->select('eglises.*')
                 ->get();
        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        foreach($query as $row){
            $output .= '<option value="'.$row->id.'">'.$row->nom.'-'.$row->quartier.'</option>';
        }
        echo $output;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $tab = [
            'titre1' => 'Voir Utilisateurs',
            'titre2' => 'Utilisateurs'
        ];
        //$user = User::where('id','=',session('LoggedUser'))->first();
        $user = DB::table('users')
            ->where('id', Auth::user()->id)
            ->first();
        $loggedUserInfo = $user;
        $url = $_SERVER['REQUEST_URI'];
        $id = substr($url, 10);
        //dd($id);
        $dbid = User::where('uuid', $id)->first();
        //dd($dbid['id']);
        $userInfo = DB::table('role_user')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.uuid', $id)
            ->select('roles.name as nom_role', 'roles.id as role_id', 'roles.description as description', 'users.*')
            ->get();

        //dd($userInfo);
        //dd($user);
        if (renvoiRoleUser(Auth::user()->id) || verifEgliseAppartenace($id, Auth::user()->id)) {
            return view('auth.show', compact('loggedUserInfo', 'user', 'userInfo', 'tab'));
        } else {
            return redirect()->route('auth.dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
     //dd($uuid);
      $tableau = [
            'liste' => 'Modifier Utilisateurs',
            'table' => 'Utilisateurs'
        ];
    $user1 = DB::table('users')
        ->where('id', Auth::user()->id)
        ->first();
    $loggedUserInfo = $user1;
    $url = $_SERVER['REQUEST_URI'];
    $uuid = substr($url, 10);
    //dd($id);
    $user = User::where('uuid', $uuid)->first();
    //dd($dbid['id']);
    $role = User::find($user['id'])->roles()->get();
    $roleid = $role[0]['id'];
    //dd($roleid);
    $userInfo = DB::table('role_user')
        ->join('users', 'role_user.user_id', '=', 'users.id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('users.uuid', $uuid)
        ->select('roles.name as nom_role', 'roles.id as role_id', 'roles.description as description', 'users.*')
        ->get();
        $roles = Role::All();
    //dd($userInfo);
    //dd($user);
        return view('auth.edit', compact('user', 'roles',  'roleid', 'tableau'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->role == "Veuillez Selectionner" || $request->eglise == "Veuillez Selectionner" || $request->sexe == "Veuillez Selectionner") {
            return back()->with('errorchamps', 'Echec!!!Veuillez selectionner les champs role, eglise ou sexe');
        }
        $my_image = $request->my_image;
        $image = $request->file('image');
        $url = $_SERVER['REQUEST_URI'];
        $id = substr($url, 10);
        if ($image != "") {
            $request->validate([
                'role' => 'required',
                'lastname' => 'required|min:4',
                'firstname' => 'required|min:4',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|min:8',
                'sexe' => 'required',
                'password' => 'required|min:8|max:12',
                'new_confirm_password' => 'required|same:password',
                "image" => "required|image|max:7048"

            ]);
            $my_image = rand() . '.' . $image->getClientOriginalExtension();
            //$image->move(public_path('upload'),$my_image);
            $image->move($_SERVER['DOCUMENT_ROOT'] . '/upload', $my_image);
        } else {

            $request->validate([
                'role' => 'required',
                'lastname' => 'required|min:4',
                'firstname' => 'required|min:4',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|min:8',
                'sexe' => 'required',
                'password' => 'required|min:8|max:12',
                'new_confirm_password' => 'required|same:password'

            ]);
        }

        //dd($url);
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->name = $request->lastname;
            $user->firstname = $request->firstname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->birthdate = $request->date_input;
            $user->sexe = $request->sexe;
            $user->online = "oui";
            $user->password = Hash::make($request->password);
            $user->image = $my_image;
            $query = $user->save();
            DB::table('role_user')
                ->where('user_id', $id)
                ->update(['role_id' => $request->role]);
            if ($query) {
                return redirect()->route('user.index')->with('success', 'La modification a été faite avec succès!');

            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', $e);
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
                $user = User::find($id);
                $user->delete();
                foreach (DB::table('role_user')->where('user_id', $id)->cursor() as $roleuser) {
                    DB::table('role_user')->delete($roleuser->id);
                }
                return redirect()->route('user.index')->with('succesdanger', 'La suppression a été faite avec succès');
                
    }
}
