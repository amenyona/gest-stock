@extends('admincreate')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mt-4">
                    <div class="alert alert-warning" role="alert">
                        <strong style="text-transform: uppercase;font-style: italic;font-size: 2em;">Vous êtes sur la page des requêtes concernant le stock</strong>
                    </div>

                </div> 
                <div class="mt-4">
                    <a href="{{route('fournisseur.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                </div> 
                <form action="{{route('stock.rechercherStockAlert')}}" method="POST">
                    @csrf

                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                    
                @endif
                @if (session()->has('errorchamps'))
                <div class="alert alert-danger">
                    {{session()->get('errorchamps')}}
                </div>
                @endif
               <br>
               <div class="row">
                
                <br>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Les quantités alertes des produits</label>
                                <select class="form-control select2 stock" name="alerte"> 
                                    <option>Veuillez Selectionner</option>
                                @foreach($alertes as $alerte)
                                <option value="{{$alerte->quantiteAlert}}" con="">{{$alerte->quantiteAlert}}</option>                                                                                                        
                                @endforeach                                                                                                         
                                </select>
                       </div>     
                    
                  <div class="lg-3">
                    </div>  
                </div>

                <div class="col-sm-6">
     
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Démarrer la recherche</button>                     
                </div> 
            </div>

        </form>
               

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
