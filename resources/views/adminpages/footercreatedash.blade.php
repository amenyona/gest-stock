
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Skote.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
<div data-simplebar class="h-100">
<div class="rightbar-title d-flex align-items-center px-3 py-4">

    <h5 class="m-0 me-2">Settings</h5>

    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
        <i class="mdi mdi-close noti-icon"></i>
    </a>
</div>

<!-- Settings -->
<hr class="mt-0" />
<h6 class="text-center mb-0">Choose Layouts</h6>

<div class="p-4">
    <div class="mb-2">
        <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
    </div>

    <div class="form-check form-switch mb-3">
        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
    </div>
    <div class="form-check form-switch mb-3">
        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
    </div>
    <div class="form-check form-switch mb-3">
        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
    </div>

    <div class="mb-2">
        <img src="assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
    </div>
    <div class="form-check form-switch mb-5">
        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
    </div>


</div>

</div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js')}}"></script>

<!-- form advanced init -->
<script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
</body>
</html>

<script>
    $(document).ready(function(){
        $('.jkk').change(function(){
            alert(ok)
            if($(this).val()!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.classeecompo').attr('dependente');
                var _token = $('input[name="_token"]').val();
                idAnneeAcademique = value;
                $.ajax({
                    url : "{{route('famille.fetchFamilleForme')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        $('.classeecompo').html(result)
                    }

                    })
            }
        });

        $(document).on('change', '.selectforme', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    //alert(selectedValue)
    console.log('Option sélectionnée : ' + selectedValue);
    if(selectedValue!=''){
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.forme').attr('dependente');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url : "{{route('famille.fetchFamilleForme')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        //console.log(result)
                        $('.forme').html(result)
                    }

                    })
            }
        });

        $(document).on('change', '.fournisseurId', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    //alert(selectedValue)
    //console.log('Option sélectionnée : ' + selectedValue);
    if(selectedValue!=''){
                var value = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url : "{{route('fournisseur.fetchFoirnisseurId')}}",
                    method : "POST",
                    data:{ value:value, _token:_token},
                    
                    success:function(result){
                        console.log(result)
                        
                    }

                    })
            }
        });

        $(document).on('change', '.etat', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    //alert(selectedValue)
    //console.log('Option sélectionnée : ' + selectedValue);
    if(selectedValue!=''){
                
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent  = $('.numerocomande').attr('dependente');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url : "{{route('fournisseur.fetchNumeroCommande')}}",
                    method : "POST",
                    data:{select:select, value:value, _token:_token,dependent:dependent},
                    
                    success:function(result){
                        //console.log(result)
                        $('#numerocomande').html(result)
                    }

                    })
            }
        });


    })
    </script>