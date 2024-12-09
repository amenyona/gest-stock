<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Achat Direct - Pharmacie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers un fichier CSS externe -->
</head>
<body>

    <header>
        <h1>Achat Direct - Pharmacie</h1>
    </header>

    <main>
        <form action="/submit-direct-purchase" method="POST">
            <!-- Informations sur le fournisseur -->
            <fieldset>
                <legend>Informations du fournisseur</legend>
                
                <label for="nom_fournisseur">Nom du fournisseur :</label>
                <input type="text" id="nom_fournisseur" name="nom_fournisseur" required>
                
                <label for="telephone_fournisseur">Téléphone :</label>
                <input type="tel" id="telephone_fournisseur" name="telephone_fournisseur" required>
                
                <label for="email_fournisseur">Email :</label>
                <input type="email" id="email_fournisseur" name="email_fournisseur">
            </fieldset>

            <!-- Détails du produit à acheter -->
            <fieldset>
                <legend>Détails du produit</legend>

                <label for="nom_produit">Nom du produit :</label>
                <input type="text" id="nom_produit" name="nom_produit" required>
                
                <label for="code_produit">Code produit :</label>
                <input type="text" id="code_produit" name="code_produit" required>

                <label for="quantite_produit">Quantité :</label>
                <input type="number" id="quantite_produit" name="quantite_produit" required>

                <label for="prix_unitaire">Prix unitaire :</label>
                <input type="number" id="prix_unitaire" name="prix_unitaire" step="0.01" required>
                
                <label for="date_achat">Date d'achat :</label>
                <input type="date" id="date_achat" name="date_achat" required>
            </fieldset>

            <!-- Informations sur le paiement -->
            <fieldset>
                <legend>Détails du paiement</legend>

                <label for="mode_paiement">Mode de paiement :</label>
                <select id="mode_paiement" name="mode_paiement" required>
                    <option value="carte">Carte bancaire</option>
                    <option value="espece">Espèces</option>
                    <option value="virement">Virement bancaire</option>
                </select>

                <label for="montant_total">Montant total :</label>
                <input type="number" id="montant_total" name="montant_total" step="0.01" required>
            </fieldset>

            <!-- Boutons d'action -->
            <button type="submit">Confirmer l'achat</button>
            <button type="reset">Réinitialiser</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Pharmacie. Tous droits réservés.</p>
    </footer>

</body>
</html>
