@extends('adminfichetraitement')
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
                <div class="mt-4">
                    <div class="alert alert-warning" role="alert">
                        Vousss êtes en train de passer votre commande avec votre fournisseur  <strong style="text-transform: uppercase;font-style: italic;font-size: 2em;">{{retreiveFournisseur(session()->get('keyf'))}}</strong>
                    </div>

                </div>
        
                <form action="{{route('fournisseur.traiterCommande')}}" method="POST" enctype="multipart/form-data">
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
                   
                        <table class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité Livrée</th>
                                    <th>Prix Livraison</th>
                                    <th><button type="button" name="addi" class="btn btn-success btn-xs addi"><i class="bx bx-plus"></i></button></th>
                                </tr>
                            </thead>
    
                            <tbody id="result">
    
                            </tbody>
                        </table>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="fichier">Preuve du Réglement</label>
                                    <input class="form-control form-control-lg" id="formFileLg" type="file" name="fichier">

                                </div>
                                <div class="mb-3">
                                    <label for="nature">Nature de  paiement</label>
                                    <select class="form-control select2" name="nature" required> 
                                        <option>Veuillez Selectionner</option>
                                        <option value="espece">Espèce</option>
                                        <option value="cheque">Chèque</option>
                                    </select>
                                </div>
                        </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="montant">Montant</label>
                                    <input class="form-control form-control-lg" id="montant" type="text" name="montant">
                                </div>
                                <div class="mb-3">
                                    <label for="quantiteAlerte">Quantité Alerte</label>
                                    <input id="quantiteAlerte" name="quantiteAlerte" type="text" class="form-control" placeholder="Entrer la quantité alerte" value="{{old('quantiteAlerte')}}">
                                    <span class="text-danger">@error('quantiteAlerte'){{ $message }}
                                        @enderror
                                     </span>
                                </div>   

                                                                            
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="quantiteSeuil">Quantité Seuil</label>
                                    <input id="quantiteSeuil" name="quantiteSeuil" type="text" class="form-control" placeholder="Entrer la quantité Seuil" value="{{old('quantiteSeuil')}}">
                                    <span class="text-danger">@error('quantiteSeuil'){{ $message }}
                                        @enderror
                                     </span>
                                </div>
    
                               
                        </div>
                            <div class="col-sm-6">
                                
    
                                                          
                        </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary buttonSav" value="Insert" disabled="">Enregistrer</button>
                        </div>
    
                    
                    
                    
                    
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection