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
                         <strong style="text-transform: uppercase;font-style: italic;font-size: 1.8em;"> Vous êtes en train d'opérer une vente suivant une ordonnace prescrite</strong>
                    </div>

                </div>
        
                <form action="{{route('ordonnance.store')}}" method="POST" enctype="multipart/form-data">
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
                                    <th>Quantité vendue</th>
                                    <th>Prix de vente</th>
                                    <th><button type="button" name="ajoutord" class="btn btn-success btn-xs ajoutord"><i class="bx bx-plus"></i></button></th>
                                </tr>
                            </thead>
    
                            <tbody id="resultat">
    
                            </tbody>
                        </table>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="fichier">Fiche ordonnance</label>
                                    <input class="form-control form-control-lg" id="formFileLgo" type="file" name="fichier">
                                </div>
                                <div class="mb-3">
                                    <label class="control-label">Patients</label>
                                    <select class="form-control select2" name="patient"> 
                                        <option>Veuillez Selectionner</option>
                                        @foreach ($patients as $item)
                                        <option value="{{$item->id}}">{{$item->nom}}   {{$item->prenom}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                                         
                        </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Medecins</label>
                                    <select class="form-control select2" name="medecin"> 
                                        <option>Veuillez Selectionner</option>
                                        @foreach ($medecins as $item)
                                        <option value="{{$item->id}}">{{$item->nom}}  {{$item->prenom}}</option>
                                        @endforeach                                        
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dateprescription">Date prescription de l'ordonnance</label>
                                    <input class="form-control form-control-lg" id="dateprescription" type="date" name="dateprescription">
                                </div>                                              
                        </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary buttonajoutord" value="Insert" disabled="">Enregistrer</button>
                        </div>                    
                </form>
              
            </div>
        </div>     
    </div>
</div>

@endsection