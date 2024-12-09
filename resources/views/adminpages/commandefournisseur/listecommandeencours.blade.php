@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="mt-4">
                    <a href="{{route('fournisseur.rechercherLesommandes')}}" class="btn btn-primary waves-effect waves-left btn-sm">Revenir à la recherche <i class="mdi mdi-arrow-left ms-1"></i></a>
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
                        <th>Fournisseur</th>
                        <th>Quantité commandée</th>
                        <th>Date commande</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($commandes as $item)
                            <tr>

                                <td>{{$item->produitnom}}</td>
                                <td>{{$item->raisonSocial}}</td>                                
                                <td>{{$item->quantitefourniprod}}</td>                                
                                <td>{{$item->datefourniprod}}</td>                                
                                <td>
                                    <a href="#" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                                    <form style="display: inline-block;" action="#" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#"  onclick="return confirm('Etes vous s&ucirc;r de supprimer cette famille de médicaments ?')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
                                        <input name="_method" type="hidden" value="DELETE" class="far fa-trash-alt">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">                      
                                  </form>
                                </td>
                                
                            </tr>
                        @endforeach                    
   
                    </tbody>
                </table>
                 <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$commandes->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$commandes->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
