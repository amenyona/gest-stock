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
                <div class="mt-4">
                    <div class="alert alert-warning" role="alert">
                        <strong style="text-transform: uppercase;font-style: italic;font-size: 2em;">Vous êtes en train de créer une vente pour un client</strong>
                    </div>

                </div>
        
                <form action="{{route('ventes.store')}}" method="POST">
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
                    <form action="{{route('fournisseur.commandeFournisseur')}} method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité vendue</th>
                                    <th>Prix unitaire</th>
                                    <th><button type="button" name="ajout" class="btn btn-success btn-xs ajout"><i class="bx bx-plus"></i></button></th>
                                </tr>
                            </thead>
    
                            <tbody id="affecte">
    
                            </tbody>
                        </table>
    
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary buttonAjout" value="Insert" disabled="">Enregistrer</button>
                        </div>
    
                    </form>
                    
                    
                    
                    {{ csrf_field() }}
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection