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
                <h4>Commandes en cours de livraison chez {{retreiveFournisseur(session()->get('keyf'))}}</h4> 
                Nous avons au total {{countCommande(session()->get('keye'),session()->get('keyf'))}} commandes en cours de livraison
                
    </header>
    <main>
        <section id="section2">
            <p><h2>Produits en cours de livraison au numéro de commande : {{session()->get('keynumerocommande')}}</h2></p>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                    <th>Nom Produit</th>
                        <th>Quantité</th>
                        <th>Date Commande</th> 
                    </tr>
                </thead>
                <tbody>
                @foreach ($commandes as $item)
                    <tr>                   
                        <td>{{$item->produitnom}}</td>
                        <td>{{$item->quantitefourniprod}}</td>
                        <td>{{$item->datefourniprod}}</td>                                                
                    </tr>
                    @endForeach
 
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 MonSiteWeb. Tous droits réservés.</p>
    </footer>

    <script src="scripts.js"></script> <!-- Lien vers un fichier JavaScript -->
</body>
</html>
