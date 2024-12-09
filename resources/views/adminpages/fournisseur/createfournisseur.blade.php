@extends('admincreate')
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

                <form action="{{ route('fournisseur.store') }}" method="POST">
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
                            <a href="{{route('fournisseur.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="raisonSocial">Raison social</label>
                                <input type="text" class="form-control"  name="raisonSocial" placeholder="Entrer le nom" value="{{old('raisonSocial')}}">
                                   <span class="text-danger">@error('raisonSocial'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="adresse">Adresse</label>
                                <input type="text" class="form-control"  name="adresse" placeholder="Entrer l'adresse" value="{{old('adresse')}}">
                                   <span class="text-danger">@error('adresse'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            
                                                    
                        </div>

                        <div class="col-sm-6">

                            
                            <div class="mb-3">
                                <label for="telephone">Téléphone </label>
                                <input id="telephone" name="telephone" type="text" class="form-control" placeholder="Entrer telephone" value="{{old('telephone')}}">
                                <span class="text-danger">@error('telephone'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Entrer email" value="{{old('email')}}">
                                <span class="text-danger">@error('email'){{ $message }}
                                    @enderror
                                 </span>
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