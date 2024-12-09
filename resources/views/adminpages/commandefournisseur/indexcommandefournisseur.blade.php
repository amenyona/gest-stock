@extends('admincreate')
@section('content')
  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('fournisseur.createCommande')}}" method="POST">
                    @csrf

                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
                    
                @endif
                @if (session()->has('errorchamps'))
                <div class="alert alert-danger">
                    {{session()->get('errorchamps')}}
                </div>
                @endif
               <br>
               <div class="row">
                
                <br>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Fournisseurs</label>
                                <select class="form-control select2" name="fournisseur" required> 
                                    <option>Veuillez Selectionner</option>
                                    @foreach ($fournisseurs as $item)
                                    <option value="{{$item->id}}">{{$item->raisonSocial}}</option>
                                    @endforeach                                    
                                </select>
                       </div>     
                    
                  <div class="lg-3">
                        <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">Démarrer la commande à l'endroit de ce fournisseur</button>                     
                    </div>  
                </div>

                <div class="col-sm-6">
                       
                                      
                    
                </div>
            </div>
        </form>
               

            </div>
        </div>
    </div> <!-- end col -->
  </div> <!-- end row -->  
@endsection
