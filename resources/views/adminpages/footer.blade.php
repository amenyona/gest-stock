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
<!-- select 2 plugin -->
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<!-- Required datatable js -->
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<!-- Buttons examples -->
<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.j')}}s"></script>
<script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script> 

<!-- apexcharts -->
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- dashboard blog init -->
<script src="{{asset('assets/js/pages/dashboard-blog.init.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>

</body>
</html>

<script>

$(document).ready(function(){
    var count1 = 0;
    var compteur = 0; 
    var jas= '<?php  echo countCommande(session()->get('keye'),session()->get('keyf')); ?>'

$('.dynamique').change(function(){

if($(this).val()!=''){
var value = $(this).val();
var dependent  = $('.classee').attr('dependente');
alert(dependent)
}


});
// $('.church').change(function(){
//     var value = $(this).val();
//     alert(value)

// })

var produitss = <?php echo json_encode(renvoiProduitfs(session()->get('keye'),session()->get('keyf'))); ?>;
$('.addi').click(function(){
    
$(".buttonSav").prop('disabled', false);     
count1++;
jas=jas-1;
if(jas===0){
    $(".addi").hide();
 } 
//alert(count);
var html2 = '';
html2 += '<tr id="'+count1+'">';
//html2 +='<td><select class="form-control select2" data-sub_user_id="'+count1+'" name="item_produit[]" required> <?php  echo renvoiProduitfs(session()->get('keye'),session()->get('keyf')); ?> </select></td>';
html2 += '<td><select class="form-control select2 produit" data-sub_user_id="'+count1+'" name="item_produit[]" required><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + produitss.map(produit => '<option value="'+produit.produitid+'">'+produit.produitnom+'</option>').join('') + '</select></td>';
html2 +='<td><input type="text"  name="item_quantitelivree[]" class="form-control item_quantitelivree" required/></td>';
html2 +='<td><input type="text"  name="item_prixlivraison[]" class="form-control item_prixlivraison" required/></td>';

$('#result').append(html2); 

})
$(document).on('click', '.pro', function(){
var button_id = $(this).attr("id");
$("tr#"+button_id).remoordve();
count1--
//alert(count)
if(count1 <= 0){
$(".buttonSav").prop('disabled', true); 
$(".addi").fadeIn();
count1=0
}
});
$(document).on('change', '.produit', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    console.log('Option sélectionnée : ' + selectedValue);
    var parentRow = $(this).closest('tr');  // Récupérer la ligne parente (<tr>)
    // Attribuer une valeur à `item_prixunitairev[]` basée sur la sélection
    //quantiteField.val(selectedValue);  // Par exemple, utiliser la valeur sélectionnée (vous pouvez la changer)
    // Afficher dans la console pour vérifier
    console.log('Quantité mise à jour avec la valeur : ' + selectedValue)
    var selectedText = $(this).find('option:selected').text();
    $('.produit').not(this).each(function(){
        $(this).find('option[value="'+selectedValue+'"]').remove();
    })

    
});

var produits = <?php echo json_encode(renvoiProduitss()); ?>;
    $('.ajoutord').click(function(){
        $(".buttonajoutord").prop('disabled', false);     
        compteur++;
        //alert(count);
        var html = '';
        html += '<tr id="'+compteur+'">';
        html += '<td><select class="form-control select2 produi" data-sub_user_id="'+compteur+'" name="item_produitv[]" required><option value="Veuillez Sélectionner">Veuillez Sélectionner</option>' + produits.map(produit => '<option value="'+produit.id+'">'+produit.nom+'</option>').join('') + '</select></td>';
        html +='<td><input type="text"  name="item_quantitev[]" class="form-control item_quantite" required/></td>';
        html +='<td><input type="text"  name="item_prixunitairev[]" class="form-control item_prixunitairev" required readonly/></td>';
        html +='<td><button type="button" id="'+compteur+'" name="remoord" class="btn btn-danger btn-xs remoord"><i class="far fa-trash-alt"></i></button></td>';
        
        $('#resultat').append(html); 
       
        })
        $(document).on('click', '.remoord', function(){
        var button_id = $(this).attr("id");
        $("tr#"+button_id).remove();
        compteur--
        //alert(compteur)
        if(compteur <= 0 ){
            $(".buttonajoutord").prop('disabled', true); 
        }
    });

    $(document).on('change', '.produi', function() {
    // Code à exécuter lorsqu'une option est sélectionnée
    var _token = $('input[name="_token"]').val();
    var selectedValue = $(this).val();  // Récupérer la valeur sélectionnée
    console.log('Option sélectionnée : ' + selectedValue);
    var parentRow = $(this).closest('tr');  // Récupérer la ligne parente (<tr>)
    var quantiteField = parentRow.find('input[name="item_prixunitairev[]"]');  // Trouver le champ quantité
    // Attribuer une valeur à `item_prixunitairev[]` basée sur la sélection
    //quantiteField.val(selectedValue);  // Par exemple, utiliser la valeur sélectionnée (vous pouvez la changer)
    // Afficher dans la console pour vérifier
    console.log('Quantité mise à jour avec la valeur : ' + selectedValue)
    var selectedText = $(this).find('option:selected').text();
    $('.produi').not(this).each(function(){
        $(this).find('option[value="'+selectedValue+'"]').remove();
    })
    var value = selectedValue
    $.ajax({
    url: "{{ route('ventes.fetchProduitPrix') }}",  // L'URL de la route Laravel
    type: "POST",  // Méthode POST pour envoyer des données
    data: {
        _token: "{{ csrf_token() }}",  // Ajout du token CSRF pour la protection
        value: value  // La valeur envoyée au serveur
    },
    success: function(response) {
        // Traiter la réponse du serveur
        //console.log(response.prix);
        quantiteField.val(response.prix);
        
        // Vous pouvez mettre à jour votre interface avec les données reçues
    },
    error: function(xhr, status, error) {
        // Gérer les erreurs
        console.error('Erreur : ' + error);
    }
});
    // Vous pouvez ajouter du code ici pour faire d'autres actions avec selectedValue
});

})

</script>
