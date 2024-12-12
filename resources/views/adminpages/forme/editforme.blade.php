@extends('admincreate')
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

                <form action="{{route('forme.update',$forme->uuid)}}" method="POST">
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
                            <a href="{{route('forme.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="annee_en_cours">Famille Produit</label>
                                <select class="form-control select2" name="familles"> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($familles as $item)
                                    <option value="{{$item->id}}" <?= $forme['famille_id'] == $item->id ? ' selected="selected"' : '';?>>{{$item->nom}}</option>
                                    @endforeach                            
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control"  name="nom"  value="{{$forme->nom}}">
                                   <span class="text-danger">@error('nom'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
                            <input type="hidden" name="id" value="{{$forme->id}}">
                            
                        </div>
                        <div class="col-sm-6">
                            
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="textarea"  class="form-control" maxlength="225" rows="3"
                                                >{{$forme->description}}</textarea>
                                   <span class="text-danger">@error('description'){{ $message }}
                                     @enderror
                                  </span>
                            </div>
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