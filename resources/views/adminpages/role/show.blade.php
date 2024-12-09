@extends('admin')
@section('content')
 <!-- start page title -->
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">R&ocirc;le Detail</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">R&ocirc;les</a></li>
                    <li class="breadcrumb-item active">R&ocirc;les Detail</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="mt-4">
                        <a href="{{route('roles.index')}}" class="btn btn-primary waves-effect waves-light btn-sm">Aller &agrave; la liste <i class="mdi mdi-arrow-left ms-1"></i></a>
                    </div>

                    <div class="col-xl-8">
                        <div class="mt-4 mt-xl-3">
                          

                          
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div>
                                        <p class="textForm"><i class="me-2 text-primary "></i>Nom: {{$role->name}}</p>
                                        <p class="textForm"><i class="font-size-16 align-middle text-primary me-1"></i>Description: {{$role->description}}</p>
                                       
                                    </div>
                                </div>
                               
                            </div>

                        </div>
                    </div>
                </div>


              
            </div>
        </div>
      
    </div>
</div>
@endsection