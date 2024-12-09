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
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="mt-4">
                <div class="alert alert-warning" role="alert">
                    <strong style="text-transform: uppercase;font-style: italic;font-size: 2em;">Vous êtes sur la fiche de toutes les ventes qui ont été opérées</strong>
                </div>

            </div>
                <div class="mt-4">
                    <a href="{{route('ventes.create')}}" class="btn btn-primary waves-effect waves-right btn-sm">Créer une vente <i class="mdi mdi-arrow-right ms-1"></i></a>
                </div>
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                    
                @endif
                @if (session()->has('succesdanger'))
                <div class="alert alert-danger">
                    {{session()->get('succesdanger')}}
                </div>
                @endif
               <br>
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité vendue</th>
                        <th>Prix unitaire</th>
                        <th>Date vente</th>                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($ventes as $item)
                            <tr>

                                <td>{{$item->produitnom}}</td>
                                <td>{{$item->quantiteVendue}}</td>                                
                                <td>{{$item->prixUnitaireProdVente}}</td>                                
                                <td>{{$item->dateVente}}</td>                                
                                <td>
                                    <a href="#" class="btn btn-warning waves-light waves-effect">Voir plus</a>
                                    
                                </td>
                                
                            </tr>
                        @endforeach                    
   
                    </tbody>
                </table>
                 <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$ventes->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$ventes->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
