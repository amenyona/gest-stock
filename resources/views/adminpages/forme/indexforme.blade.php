@extends('admin')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                
                  
                  <div class="col-sm-6">
                    
                    <div class="mb-3">
                      <a href="{{route('forme.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er famille de produits<i class="mdi mdi-arrow-right ms-1"></i></a>

                    </div>
                  </div>
 
                  <div class="col-sm-6">
                             
                    <div class="mb-3">
                        
                        <a href="{{route('forme.imprime')}}" class="btn btn-outline-info waves-effect waves-light btn-sm"><i class="bx bx-printer"></i>Imprimer
                        </a>

                    </div>
                  </div>
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
                        <th>Nom</th>
                        <th>Description</th>
                        
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                        @foreach ($formes as $item)
                            <tr>

                                <td>{{$item->nom}}</td>
                                <td>{{$item->description}}</td>
                                
                                <td>
                                    <a href="{{route('forme.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                                    <form style="display: inline-block;" action="#" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('forme.destroy',$item->uuid)}}"  onclick="return confirm('Etes vous s&ucirc;r de supprimer cette forme de médicaments ?')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
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
                                <a class="page-link" href="{{$formes->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$formes->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
