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

                <div class="row">
                
                  
                    <div class="col-sm-6">
                      
                      <div class="mb-3">
                        <a href="{{route('produit.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er produit <i class="mdi mdi-arrow-right ms-1"></i></a>
  
                      </div>
                    </div>
   
                    <div class="col-sm-6">
                               
                      <div class="mb-3">
                          
                          <a href="{{route('produit.imprime')}}" class="btn btn-outline-info waves-effect waves-light btn-sm"><i class="bx bx-printer"></i>Imprimer
                          </a>
  
                      </div>
                    </div>
                </div>
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
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantité En Stock</th>
                        <th>Date Expiration</th>
                        <th>Quantité Seuil</th>
                        <th>Forme</th>
                        <th>Famille</th>
                        <th>Actions</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($produits as $item)
                    <tr>
                        <td>{{$item->nom}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->prix}}</td>
                        <td>{{$item->quantiteStock}}</td>
                        <td>{{$item->dateExpiration}}</td>
                        <td>{{$item->quantiteSeuil}}</td>
                        <td>{{implode(',',$item->forme()->get()->pluck('nom')->toArray())}}</td>
                        <td>{{implode(',',$item->famille()->get()->pluck('nom')->toArray())}}</td>
                        <td>
                            <a href="#" class="btn btn-primary waves-light waves-effect"><i class="fa fa-exclamation-circle"></i></a>
                            <a href="{{route('produit.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                            <form style="display: inline-block;" action="#" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="#"  onclick="return confirm('Etes vous sûr?Cette suppresion e repectorier sur les utilisateurs du role.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
                                <input name="_method" type="hidden" value="DELETE" class="far fa-trash-alt">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">                                
                          </form>
                        </td>
                    </tr>
                    @endForeach

                    </tbody>
                </table>
                <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$produits->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$produits->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection