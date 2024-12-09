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
        <h1>Bienvenue sur ma page avec une table</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#section1">Introduction</a></li>
            <li><a href="#section2">Table des données</a></li>
        </ul>
    </nav>

    <main>
        <section id="section1">
            <h2>Introduction</h2>
            <p>Ceci est une page web qui contient une table HTML.</p>
        </section>

        <section id="section2">
            <h2>Table des Données</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité disponible</th>
                        <th>Quantité alert</th>
                        <th>Quantité seuil</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $item)
                            <tr>

                                <td>{{retreiveNomProduit($item->produit_id)}}</td>
                                <td>{{$item->quantité}}</td>                                
                                <td>{{$item->quantiteAlert}}</td>                                
                                <td>{{$item->quantiteSeuil}}</td>                                
                                <td>
                                    <a href="{{route('fournisseur.indexCommande')}}" class="btn btn-warning waves-light waves-effect">Commander ce produit</a>
                                    
                                </td>                               
                                                           
                               
                                
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
