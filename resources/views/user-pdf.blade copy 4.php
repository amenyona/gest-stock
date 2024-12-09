<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Formulaire de Commande de Stock - Pharmacie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers un fichier CSS externe -->
</head>
<body>

    <header>
        <h1>Formulaire de Commande de Stock - Pharmacie</h1>
    </header>

    <main>
        <form action="/submit-stock-order" method="POST">
            <!-- Informations du fournisseur -->
            <fieldset>
                <legend>Informations du fournisseur</legend>
                
                <label for="nom_fournisseur">Nom du fournisseur :</label>
                <input type="text" id="nom_fournisseur" name="nom_fournisseur" required>
                
                <label for="telephone_fournisseur">Téléphone :</label>
                <input type="tel" id="telephone_fournisseur" name="telephone_fournisseur" required>
                
                <label for="email_fournisseur">Email :</label>
                <input type="email" id="email_fournisseur" name="email_fournisseur" required>
                
                <label for="adresse_fournisseur">Adresse :</label>
                <input type="text" id="adresse_fournisseur" name="adresse_fournisseur" required>
            </fieldset>

            <!-- Détails du produit à commander -->
            <fieldset>
                <legend>Détails du produit</legend>

                <label for="nom_produit">Nom du produit :</label>
                <input type="text" id="nom_produit" name="nom_produit" required>
                
                <label for="dosage_produit">Dosage (mg) :</label>
                <input type="number" id="dosage_produit" name="dosage_produit">
                
                <label for="quantite_produit">Quantité à commander :</label>
                <input type="number" id="quantite_produit" name="quantite_produit" required>
                
                <label for="date_besoin">Date requise :</label>
                <input type="date" id="date_besoin" name="date_besoin" required>
            </fieldset>

            <!-- Informations supplémentaires -->
            <fieldset>
                <legend>Informations supplémentaires</legend>
                
                <label for="methode_livraison">Méthode de livraison :</label>
                <select id="methode_livraison" name="methode_livraison">
                    <option value="standard">Livraison standard</option>
                    <option value="express">Livraison express</option>
                    <option value="pickup">Retrait en entrepôt</option>
                </select>

                <label for="remarques">Remarques supplémentaires :</label>
                <textarea id="remarques" name="remarques" rows="4"></textarea>
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
