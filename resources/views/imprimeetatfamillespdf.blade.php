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
        <h1>Bienvenue sur la page des familles des produits</h1>
    </header>



    <main>


        <section id="section2">
            <h2>Table des Données</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($familles as $item)
                    <tr>
                        
                    <td>{{$item->nom}}</td>
                    <td>{{$item->description}}</td>
                       
                    </tr>
                    @endForeach
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Amenyona Enyo LATE</p>
    </footer>

    <script src="scripts.js"></script> <!-- Lien vers un fichier JavaScript -->
</body>
</html>
