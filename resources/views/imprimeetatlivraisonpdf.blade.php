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
        <h1>Bienvenue sur la page dont les produits ont atteint le seuil d'alerte de commande</h1>
    </header>



    <main>


        <section id="section2">
            <h2>Table des Données</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité disponible</th>
                        <th>Quantité alert</th>
                        <th>Quantité seuil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $item)
                            <tr>

                                <td>{{retreiveNomProduit($item->produit_id)}}</td>
                                <td>{{$item->quantité}}</td>                                
                                <td>{{$item->quantiteAlert}}</td>                                
                                <td>{{$item->quantiteSeuil}}</td>                                
                                                  
                               
                                
                            </tr>
                        @endforeach 
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
