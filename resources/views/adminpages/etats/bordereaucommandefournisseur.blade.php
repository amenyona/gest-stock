<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ma Page avec Table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers une feuille de styles CSS -->
    <style>
        .idshowimg{
                   height: 70px;
                   width: 70px;
               }
    </style>
</head>
<body>

    <header style="text-align: center">
        <img class="idshowimg" src="assets/images/logo/donbosco.png" alt="" height="19">           
        <p> CENTRE DE FORMATION PROFESSIONNELLE DON BOSCO</p>
                <p> BP 5350, Ouagadougou</p>
                <p>TEL: +226 60 02 18 18</p>
<h4>Bordereau de commande de produits adressé à {{retreiveFournisseur(session()->get('keyFournisseur'))}}
    ce {{session()->get('datecommande')}}
</h4>
    </header>

    <main>

        <section id="section2">
            <h2>Numéro de commande : {{session()->get('numerocommande')}}</h2>
            <h2>Les produits commandés</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                    <th>Nom Produit</th>
                        <th>Quantité</th>
                        <th>Date de livraison expérée</th> 
                    </tr>
                </thead>
                <tbody>
                @foreach ($commandes as $item)
                    <tr>
                    
                        <td>{{retreiveNomProduit($item['produit_id'])}}</td>
                        <td>{{$item['quantiteCommande']}}</td>
                        <td>{{$item['dateExpereLivraison']}}</td>
                        
                        
                    </tr>
                    @endForeach
 
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 CENTRE DE FORMATION PROFESSIONNELLE DON BOSCO. Tous droits réservés.</p>
    </footer>

    <script src="scripts.js"></script> <!-- Lien vers un fichier JavaScript -->
</body>
</html>
