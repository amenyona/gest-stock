@extends('admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Modifier R&ocirc;le</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">R&ocirc;les</a></li>
                    <li class="breadcrumb-item active">Modifier R&ocirc;le</li>
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

                <form action="{{route('stock.updateStock',$stock['id'])}}" method="POST">
                    @csrf
                    @method('PUT')
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
                    <div class="row">
                        <div class="mt-4">
                            <a href="{{route('stock.liststock')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="nom">Quantite alert</label>
                                    <input type="text" class="form-control"  name="quantiteAlert"  value="{{$stock['quantiteAlert']}}">
                                       <span class="text-danger">@error('quantiteAlert'){{ $message }}
                                         @enderror
                                      </span>
                                </div>
                                <label for="nom">Quantite seuil</label>
                                <input type="text" class="form-control"  name="quantiteSeuil"  value="{{$stock->quantiteSeuil}}">
                                   <span class="text-danger">@error('quantiteSeuil'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <input type="hidden" name="id" value="{{$stock['id']}}">
                            
                        </div>

                        
                    </div>
                    
                    
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Mettre &agrave; jour</button>
                        
                    </div>
                    
                </form>
              
            </div>
        </div>

       
       
    </div>
</div>

@endsection