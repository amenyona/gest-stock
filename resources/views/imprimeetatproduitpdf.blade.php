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
        <h1>Bienvenue sur la page des produits</h1>
    </header>



    <main>


        <section id="section2">
            <h2>Table des Données</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantité En Stock</th>
                        <th>Date Expiration</th>
                        <th>Quantité Seuil</th>
                        <th>Forme</th>
                        <th>Famille</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $item)
                    <tr>
                        <td>{{$item->nom}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->prix}}</td>
                        <td>{{$item->quantiteStock}}</td>
                        <td>{{$item->dateExpiration}}</td>
                        <td>{{$item->quantiteSeuil}}</td>
                        <td>{{implode(',',$item->forme()->get()->pluck('nom')->toArray())}}</td>
                        <td>{{implode(',',$item->famille()->get()->pluck('nom')->toArray())}}</td>
                       
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
