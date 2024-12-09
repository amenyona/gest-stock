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
                    <a href="{{route('roles.create')}}" class="btn btn-primary waves-effect waves-light btn-sm">Cr&eacute;er r&ocirc;le<i class="mdi mdi-arrow-right ms-1"></i></a>
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

                        @foreach ($roles as $item)
                            <tr>

                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                
                                <td>
                                    <a href="{{route('roles.show',$item->uuid)}}" class="btn btn-primary waves-light waves-effect"><i class="fa fa-exclamation-circle"></i></a>
                                    <a href="{{route('roles.edit',$item->uuid)}}" class="btn btn-success waves-light waves-effect"><i class="mdi mdi-pencil"></i></a>
                                    <form style="display: inline-block;" action="#" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('roles.destroy',$item->uuid)}}"  onclick="return confirm('Etes vous s&ucirc;r?Cette suppresion e repectorier sur les utilisateurs du r&ocirc;le.')" class="btn btn-danger waves-light waves-effect"><i class="far fa-trash-alt"></i></a>
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
                                <a class="page-link" href="{{$roles->previousPageUrl()}}">Pr&eacute;c&eacute;dent</a>
                           
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="{{$roles->nextPageUrl()}}">Suivant</a>
                              </li>
                            </ul>
                          </nav>  
                </div>

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
