@extends('admin')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Data Tables</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Data Tables</li>
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
                    <a href="{{route('fournisseur.rechercherLesommandes')}}" class="btn btn-primary waves-effect waves-left btn-sm">Revenir à la recherche <i class="mdi mdi-arrow-left ms-1"></i></a>
                    <br/>  <br/>
                    <div class="alert alert-warning" role="alert">
                        <strong style="text-transform: uppercase;font-style: italic;font-size: 2em;text-align:center;">{{$etat}} auprés DE/(D') {{retreiveFournisseur($fournisseur)}}</strong>
                    </div>
                </div><br/>
                <div class="results">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                         {{Session::get('success')}}
                        </div>
                    @endif

                    @if (Session::get('succesdanger'))
                        <div class="alert alert-success">
                           {{Session::get('succesdanger')}}
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
                    <div class="col-12">
                        @if($etat=="Commandes en cours")
                        <div class="row">
                            <div class="col-xl-4">
                               
                                <a href="{{route('fournisseur.demarrerTraitementLivraison')}}" class="btn btn-success waves-light waves-effect">Traiter la commande suite à la livraison</a>
          
                            </div>
                            <div class="col-xl-4" style="font-style: italic;font-size: 1.5em;text-align:center;color:black;">
                                Nous avons au total {{countCommande(session()->get('keye'),session()->get('keyf'))}} commandes en cours de livraison
                            </div>
                            <div class="col-xl-4">
                                <a href="{{route('fournisseur.commandesencours')}}" class="btn btn-success waves-light waves-effect">Voir toute les commandes en cours</a>
                            </div>
                        </div>
                        @endif

                        @if($etat=="Commandes livrées")
                        <div class="row">
                            
                            <div class="col-xl-4" style="font-style: italic;font-size: 1.5em;text-align:center;color:black;">
                                Nous avons au total {{countCommande(session()->get('keye'),session()->get('keyf'))}} commandes en cours de livraison
                            </div>
                            <div class="col-xl-4">
                                <a href="{{route('fournisseur.commandeslivrees')}}" class="btn btn-success waves-light waves-effect">Voir toute les commandes livrées</a>
                            </div>
                        </div>
                        @endif
                        @if($etat=="Commandes annulées")
                        <div class="row">
                            
                            <div class="col-xl-4" style="font-style: italic;font-size: 1.5em;text-align:center;color:black;">
                                Nous avons au total {{countCommande(session()->get('keye'),session()->get('keyf'))}} commandes en cours de livraison
                            </div>
                            <div class="col-xl-4">
                                <a href="#" class="btn btn-success waves-light waves-effect">Voir toute les commandes annulées</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                
                  
                    <div class="col-sm-6">
                      
                      <div class="mb-3">
  
                      </div>
                    </div>
   
                    <div class="col-sm-6">
                               
                      <div class="mb-3">
                          
                          <a href="{{route('fournisseur.imprimeListecommandeFournisseur')}}" class="btn btn-outline-info waves-effect waves-light btn-sm"><i class="bx bx-printer"></i>Imprimer
                          </a>
  
                      </div>
                    </div>
                </div>
               
            </br></br>
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                  
                        <th>Nom Produit</th>
                        <th>Quantité</th>
                        <th>Date Commande</th>                        
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($commandes as $item)
                    <tr>
                    
                        <td>{{$item->produitnom}}</td>
                        <td>{{$item->quantitefourniprod}}</td>
                        <td>{{$item->datefourniprod}}</td>
                        
                        <td>                       
                            <a href="{{route('fournisseur.demarrerTraitementLivraison',$item->uuidfourniprod)}}" class="btn btn-warning waves-light waves-effect">Voir en détail</a>                           
                        </td>
                    </tr>
                    @endForeach

                    </tbody>
                </table>
                

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection