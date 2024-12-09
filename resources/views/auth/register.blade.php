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

                <form action="{{ route('user.store') }}" method="POST">
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
                            <a href="{{route('user.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="lastname">Nom</label>
                                <input type="text" class="form-control"  name="lastname" placeholder="Entrer le nom" value="{{old('lastname')}}">
                                   <span class="text-danger">@error('lastname'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="firstname">Prénom</label>
                                <input type="text" class="form-control"  name="firstname" placeholder="Entrer le prénom" value="{{old('firstname')}}">
                                   <span class="text-danger">@error('firstname'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control"  name="email" placeholder="Entrer email" value="{{old('email')}}">
                                <span class="text-danger">@error('email'){{ $message }}
                                   @enderror
                                </span>
                            </div>
                           <div class="mb-3">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control" placeholder="Entrer phone" value="{{old('phone')}}">
                                <span class="text-danger">@error('phone'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            <div class="mb-3">
                                <label class="control-label">Sexe</label>
                                <select class="form-control select2" name="sexe">
                                    <option>Veuillez Selectionner</option>                                  
                                     <option value="feminin">feminin</option> 
                                     <option value="masculin">Masculin</option>                              
                                </select>
                            </div>
                            
                        </div>

                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label class="control-label">Roles</label>
                                <select class="form-control select2" name="role"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($roles as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
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
                                <label for="password">Confirm Password</label>
                                <input type="password" class="form-control"  name="new_confirm_password" placeholder="Confirmer le mot de passe">
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