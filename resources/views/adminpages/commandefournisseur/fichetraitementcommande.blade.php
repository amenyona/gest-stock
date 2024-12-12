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
                        Vousss êtes en train d'enregistrer la livraiosn de la commande numéro {{session()->get('keynumerocommande')}} auprès de votre fournisseur  <strong style="text-transform: uppercase;font-style: italic;font-size: 2em;">{{retreiveFournisseur(session()->get('keyf'))}}</strong>
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
                                    <th>Quantité Commandée</th>
                                    <th>Quantité Livrée</th>
                                    <th>Quantité Défectueuse</th>
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
                                    <label for="remise">Remise</label>
                                    <input class="form-control"  placeholder="Entrer la remise" id="remise" type="text" name="remise">
                                </div>
                                <div class="mb-3">
                                    <label for="livraison">Livraison</label>
                                    <select class="form-control select2 livraison" name="livraison" required> 
                                        <option>Veuillez Selectionner</option>
                                        <option value="gratuite">Gratuite</option>
                                        <option value="payée">Payée</option>
                                    </select>                                    
                                    <span class="text-danger">@error('quantiteAlerte'){{ $message }}
                                        @enderror
                                     </span>
                                </div>   

                                                                            
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                
                                <div class="mb-3">
                                    <label for="montant">Montant Total</label>
                                    <input id="montant" name="montant" type="text" class="form-control" placeholder="Entrer le montant total" value="{{old('montant')}}">
                                    <span class="text-danger">@error('montant'){{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="mb-3 montantLivraison">
                                    <label for="montantLivraison">Montant Livraison</label>
                                    <input id="montantLivraison" name="montantLivraison" type="text" class="form-control montantLivre" placeholder="Entrer montant Livraison" value="{{old('quantiteSeuil')}}">
                                    <span class="text-danger">@error('montantLivraison'){{ $message }}
                                        @enderror
                                     </span>
                                </div>                                
                                                          
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