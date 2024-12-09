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
        <h1>Bienvenue sur la page des fournisseurs</h1>
    </header>



    <main>


        <section id="section2">
            <h2>Table des Données</h2>
            <table border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Raison Sociale</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fournisseurs as $item)
                    <tr>
                        <td>{{$item->raisonSocial}}</td>
                        <td>{{$item->adresse}}</td>
                        <td>{{$item->telephone}}</td>
                        <td>{{$item->email}}</td>
                       
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
