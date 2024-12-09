<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Formulaire de Commande - Pharmacie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers un fichier CSS externe -->
</head>
<body>

    <header>
        <h1>Formulaire de Commande - Pharmacie</h1>
    </header>

    <main>
        <form action="/submit-order" method="POST">
            <!-- Informations du patient -->
            <fieldset>
                <legend>Informations du patient</legend>
                
                <label for="nom">Nom du patient :</label>
                <input type="text" id="nom" name="nom_patient" required>
                
                <label for="age">Âge :</label>
                <input type="number" id="age" name="age_patient" required>
                
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse_patient">
                
                <label for="telephone">Téléphone :</label>
                <input type="tel" id="telephone" name="telephone_patient">
            </fieldset>

            <!-- Détails du médicament -->
            <fieldset>
                <legend>Détails du médicament</legend>

                <label for="nom_medicament">Nom du médicament :</label>
                <input type="text" id="nom_medicament" name="nom_medicament" required>
                
                <label for="dosage">Dosage (mg) :</label>
                <input type="number" id="dosage" name="dosage_medicament" required>
                
                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite_medicament" required>
                
                <label for="date_prescription">Date de la prescription :</label>
                <input type="date" id="date_prescription" name="date_prescription" required>
                
                <label for="nom_docteur">Nom du docteur :</label>
                <input type="text" id="nom_docteur" name="nom_docteur">
            </fieldset>

            <!-- Options supplémentaires -->
            <fieldset>
                <legend>Options de livraison</legend>
                
                <label for="livraison">Souhaitez-vous une livraison à domicile ?</label>
                <input type="checkbox" id="livraison" name="livraison_domicile">
                
                <label for="date_livraison">Date de livraison souhaitée :</label>
                <input type="date" id="date_livraison" name="date_livraison">
            </fieldset>

            <!-- Boutons d'action -->
            <button type="submit">Envoyer la commande</button>
            <button type="reset">Réinitialiser</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Pharmacie. Tous droits réservés.</p>
    </footer>

</body>
</html>
