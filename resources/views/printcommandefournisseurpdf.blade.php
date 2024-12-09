<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ma Page avec Table</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers une feuille de styles CSS -->
</head>
<body>

    <header>
        <h1>Bienvenue sur la page  produits dont les commandes sont en cours chez {{retreiveFournisseur(session()->get('keyf'))}}</h1> <br>
        Nous avons au total {{countCommande(session()->get('keye'),session()->get('keyf'))}} commandes en cours de livraison
    </header>



    <main>


        <section id="section2">
            <h2>Table des Données</h2>
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
