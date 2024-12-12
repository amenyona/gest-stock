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
                    <a href="{{route('patient.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er patient <i class="mdi mdi-arrow-right ms-1"></i></a>
                </div><br/><br/>
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
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                      
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $item)
                    <tr>
                        <td>{{$item->nom}}</td>
                        <td>{{$item->prenom}}</td>
                        <td>{{$item->telephone}}</td>
                        <td>{{$item->email}}</td>                        
                        <td>
                            <a href="{{route('client.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                            <form style="display: inline-block;" action="{{route('patient.delete',$item->uuid)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <a href="{{route('client.delete',$item->uuid)}}"  onclick="return confirm('Etes vous sûr de supprimer ce patient ?')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
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
                                <a class="page-link" href="{{$clients->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$clients->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->



@endsection