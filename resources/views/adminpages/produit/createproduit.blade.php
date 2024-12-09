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

                <form action="{{ route('produit.store') }}" method="POST">
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
                            <a href="{{route('produit.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control"  name="nom" placeholder="Entrer le nom" value="{{old('nom')}}">
                                   <span class="text-danger">@error('nom'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <input type="text" class="form-control"  name="description" placeholder="Entrer la description" value="{{old('description')}}">
                                   <span class="text-danger">@error('description'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <div class="mb-3">
                                <label for="prix">Prix</label>
                                <input type="prix" class="form-control"  name="prix" placeholder="Entrer prix" value="{{old('prix')}}">
                                <span class="text-danger">@error('prix'){{ $message }}
                                   @enderror
                                </span>
                            </div>
                           <div class="mb-3">
                                <label for="quantiteStock">Quantite en Stock</label>
                                <input id="quantiteStock" name="quantiteStock" type="text" class="form-control" placeholder="Entrer quantite en stock" value="{{old('quantiteStock')}}">
                                <span class="text-danger">@error('quantiteStock'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                                                    
                        </div>

                        <div class="col-sm-6">

                            <div class="mb-3" id="datepicker1">
                                <label for="dateExpiration">Date Expiration</label>
                                <input id="dateExpiration" name="dateExpiration" class="form-control" type="date" value="{{old('quantiteStock')}}">
                                <span class="text-danger">@error('dateExpiration'){{ $message }}
                                    @enderror
                                 </span>
                            </div>

                            <div class="mb-3">
                                <label for="quantiteSeuil">Quantité Seuil</label>
                                <input id="quantiteSeuil" name="quantiteSeuil" type="text" class="form-control" placeholder="Entrer la quantité Seuil" value="{{old('quantiteSeuil')}}">
                                <span class="text-danger">@error('quantiteSeuil'){{ $message }}
                                    @enderror
                                 </span>
                            </div>
                            
                            <div class="mb-3">
                                <label class="control-label">Familles</label>
                                <select class="form-control select2" name="famille"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($familles as $item)
                                    <option value="{{$item->id}}">{{$item->nom}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="control-label">Formes</label>
                                <select class="form-control select2" name="forme"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($formes as $item)
                                    <option value="{{$item->id}}">{{$item->nom}}</option>
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