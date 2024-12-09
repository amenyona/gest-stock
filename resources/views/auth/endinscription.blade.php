@extends('admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{$tableau['liste']}}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{$tableau['table']}}</a></li>
                    <li class="breadcrumb-item active">{{$tableau['liste']}}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.storeinscription') }}" method="POST">
                    @csrf
                    <div class="results">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                             {{Session::get('success')}}
                            </div>
                        @endif
   
                        @if (Session::get('error'))
                            <div class="alert alert-danger">
                               {{Session::get('error')}}
                            </div>
                        @endif

                        @if (Session::get('errorchamps'))
                        <div class="alert alert-danger">
                            {{Session::get('errorchamps')}}
                         </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="mt-4">
                            <a href="{{route('auth.inscrire')}}" class="btn btn-primary waves-effect waves-light btn-sm">Revenir <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        
                        <br>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">

                                                                               <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light">Les informations concernant de l'élève</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                            <br>

                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label for="lastnameeleve">Nom de l'elève</label>
                                <input type="text" class="form-control"  name="lastnameeleve" placeholder="Entrer le nom" value="{{ !empty(Session::get('keylastnameeleve'))? Session::get('keylastnameeleve') : old('lastnameeleve')}}">
                                   <span class="text-danger">@error('lastnameeleve'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="firstnameeleve">Prénom de l'elève</label>
                                <input type="text" class="form-control"  name="firstnameeleve" placeholder="Entrer le prénom" value="{{ !empty(Session::get('keyfirstnameeleve'))? Session::get('keyfirstnameeleve') : old('firstnameeleve')}}">
                                   <span class="text-danger">@error('firstnameeleve'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="emaileleve">Email de l'elève</label>
                                <input type="emaileleve" class="form-control"  name="emaileleve" placeholder="Entrer email" value="{{ !empty(Session::get('keyemaileleve'))? Session::get('keyemaileleve') : old('emaileleve')}}">
                                <span class="text-danger">@error('emaileleve'){{ $message }}
                                   @enderror
                                </span>
                            </div>
                           <div class="mb-3">
                                <label for="phoneeleve">Phone de l'elève</label>
                                <input id="phoneeleve" name="phoneeleve" type="text" class="form-control" placeholder="Entrer phone" value="{{ !empty(Session::get('keyphoneeleve'))? Session::get('keyphoneeleve') : old('phoneeleve')}}">
                                <span class="text-danger">@error('phoneeleve'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Sexe de l'elève</label>
                                <select class="form-control select2" name="sexeeleve">
                                    <option>Veuillez Selectionner</option>                                  
                                     <option value="feminin" <?= Session::get('keysexeeleve') == 'feminin' ? ' selected="selected"' : '';?>>feminin</option> 
                                     <option value="masculin" <?= Session::get('keysexeeleve') == 'masculin' ? ' selected="selected"' : '';?>>Masculin</option>                              
                                </select>
                            </div>
                            
                            
                        </div>

                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label class="control-label">Roles</label>
                                <select class="form-control select2" name="roleeleve"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($roles as $item)
                                    <option value="{{$item->id}}" <?= Session::get('keyroleeleve') == $item->id ? ' selected="selected"' : '';?>>{{$item->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Annees</label>
                                <select class="form-control select2 dynamique" name="annees"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($annees as $item)
                                    <option value="{{$item->id}}">{{$item->annee_en_cours}}</option>
                                    @endforeach                            
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Classes</label>
                                <select class="form-control select2 classee" name="classes" dependente="classe"> 
                                    <option>Veuillez Selectionner</option>
                                                               
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="montantpaye">Scolarité payée</label>
                                <input id="montantpaye" name="montantpaye" type="text" class="form-control" placeholder="Entrer le montant à payer" value="{{old('montantpaye')}}">
                                <span class="text-danger">@error('montantpaye'){{ $message }}
                                    @enderror
                                 </span>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Versement</label>
                                <select class="form-control select2" name="natureversement">
                                    <option>Veuillez Selectionner</option>                                  
                                     <option value="premierversement">Premier versement</option> 
                                     <option value="deuxiemeversement">Deuxième versement</option>                              
                                     <option value="troisiemeversement">Troisième versement</option>                              
                                     <option value="quatriemeversement">Quatrième versement</option>                              
                                     <option value="cinquiemeversement">Cinquième versement</option>                              
                                     <option value="sixiemeversement">Sixième versement</option>                              
                                     <option value="septiemeversement">Septième versement</option>                              
                                     <option value="huitiemeversement">Huitième versement</option>                              
                                     <option value="neuviemeversement">Neuvième versement</option>                              
                                </select>
                            </div>

                            
                           
                            <div class="mb-3">
                                <label for="passwordeleve">Password</label>
                                <input type="password" class="form-control" id="horizontal-password-input" name="passwordeleve" placeholder="Entrer le mot de passe" value="{{old('passwordeleve')}}">
                                <span class="text-danger">@error('passwordeleve'){{ $message }}
                                    
                                @enderror</span>
                            </div>

                            <div class="mb-3">
                                <label for="new_confirm_passwordeleve">Confirm Password</label>
                                <input type="password" class="form-control"  name="new_confirm_passwordeleve" placeholder="Confirmer le mot de passe"  value="{{old('new_confirm_passwordeleve')}}">
                                <span class="text-danger">@error('new_confirm_passwordeleve'){{ $message }}
                                    
                                @enderror</span>
                            </div>

                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light">Les informations concernant le tuteur</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                            <br>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="lastname">Nom</label>
                                <input type="text" class="form-control"  name="lastname" placeholder="Entrer le nom" value="{{ !empty(Session::get('keylastname'))? Session::get('keylastname') : old('lastname')}}">
                                   <span class="text-danger">@error('lastname'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control"  name="firstname" placeholder="Entrer le prénom" value="{{ !empty(Session::get('keyfirstname'))? Session::get('keyfirstname') : old('firstname')}}">
                                   <span class="text-danger">@error('firstname'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control"  name="email" placeholder="Entrer email" value="{{ !empty(Session::get('keyemail'))? Session::get('keyemail') : old('email')}}">
                                <span class="text-danger">@error('email'){{ $message }}
                                   @enderror
                                </span>
                            </div>
                           <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control" placeholder="Entrer phone" value="{{ !empty(Session::get('keyphone'))? Session::get('keyphone') : old('phone')}}">
                                <span class="text-danger">@error('phone'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Sexe</label>
                                <select class="form-control select2" name="sexe">
                                    <option>Veuillez Selectionner</option>                                  
                                     <option value="feminin" <?= Session::get('keysexe') == 'feminin' ? ' selected="selected"' : '';?>>feminin</option> 
                                     <option value="masculin" <?= Session::get('keysexe') == 'masculin' ? ' selected="selected"' : '';?>>Masculin</option>                              
                                </select>
                            </div>
                            
                        </div>

                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label class="control-label">Roles</label>
                                <select class="form-control select2" name="role"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($roletuteurs as $item)
                                    <option value="{{$item->id}}" <?= Session::get('keyrole') == $item->id ? ' selected="selected"' : '';?>>{{$item->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                           
                            
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="horizontal-password-input" name="password" placeholder="Entrer le mot de passe" value="{{old('password')}}">
                                <span class="text-danger">@error('password'){{ $message }}
                                    
                                @enderror</span>
                            </div>

                            <div class="mb-3">
                                <label for="new_confirm_password">Confirm Password</label>
                                <input type="password" class="form-control"  name="new_confirm_password" placeholder="Confirmer le mot de passe" value="{{old('new_confirm_password')}}">
                                <span class="text-danger">@error('new_confirm_password'){{ $message }}
                                    
                                @enderror</span>
                            </div>

                            
                        </div>
                    </div>
                    
                    
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Enregistrer</button>
                        
                    </div>
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection