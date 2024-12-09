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

                <form action="{{ route('auth.finishInscription') }}" method="POST">
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