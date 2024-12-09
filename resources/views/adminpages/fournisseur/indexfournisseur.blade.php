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
                        <a href="{{route('fournisseur.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er fournisseur <i class="mdi mdi-arrow-right ms-1"></i></a>
  
                      </div>
                    </div>
   
                    <div class="col-sm-6">
                               
                      <div class="mb-3">
                          
                          <a href="{{route('fournisseur.imprimeFournisseur')}}" class="btn btn-outline-info waves-effect waves-light btn-sm"><i class="bx bx-printer"></i>Imprimer
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
                        <th>Raison Sociale</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th>                        
                   
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($fournisseurs as $item)
                    <tr>
                        <td>{{$item->raisonSocial}}</td>
                        <td>{{$item->adresse}}</td>
                        <td>{{$item->telephone}}</td>
                        <td>{{$item->email}}</td>
                       
                    </tr>
                    @endForeach

                    </tbody>
                </table>
                <div style="text-align: center;">
                    <nav aria-label="...">
                            <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="{{$fournisseurs->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$fournisseurs->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection