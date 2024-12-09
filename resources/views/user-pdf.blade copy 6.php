<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Achat Direct - Pharmacie</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers un fichier CSS externe -->
    <style>
        /* Styles de base */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

header {
    background-color: #28a745;
    color: white;
    text-align: center;
    padding: 15px;
    margin-bottom: 20px;
}

h1 {
    margin: 0;
    font-size: 1.6em;
}

main {
    max-width: 600px;
    margin: 0 auto;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
}

fieldset {
    border: none;
    margin-bottom: 15px;
}

legend {
    font-size: 1.1em;
    font-weight: bold;
    color: #28a745;
    margin-bottom: 10px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="tel"],
input[type="email"],
input[type="number"],
input[type="date"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 0.9em;
    box-sizing: border-box;
}

button {
    background-color: #28a745;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9em;
    transition: background-color 0.3s;
    margin-right: 10px;
}

button:hover {
    background-color: #218838;
}

button[type="reset"] {
    background-color: #dc3545;
}

button[type="reset"]:hover {
    background-color: #c82333;
}

footer {
    text-align: center;
    margin-top: 20px;
    font-size: 0.8em;
    color: #666;
}

    </style>
</head>
<body>

    <header>
        <h1>Achat Direct - Pharmacie</h1>
    </header>

    <main>
        <form action="/submit-direct-purchase" method="POST">
            <!-- Informations du fournisseur -->
            <fieldset>
                <legend>Fournisseur</legend>
                
                <label for="nom_fournisseur">Nom :</label>
                <input type="text" id="nom_fournisseur" name="nom_fournisseur" required>
                
                <label for="telephone_fournisseur">Téléphone :</label>
                <input type="tel" id="telephone_fournisseur" name="telephone_fournisseur" required>
                
                <label for="email_fournisseur">Email :</label>
                <input type="email" id="email_fournisseur" name="email_fournisseur">
            </fieldset>

            <!-- Détails du produit -->
            <fieldset>
                <legend>Produit</legend>

                <label for="nom_produit">Nom :</label>
                <input type="text" id="nom_produit" name="nom_produit" required>
                
                <label for="code_produit">Code :</label>
                <input type="text" id="code_produit" name="code_produit" required>

                <label for="quantite_produit">Quantité :</label>
                <input type="number" id="quantite_produit" name="quantite_produit" required>

                <label for="prix_unitaire">Prix unitaire :</label>
                <input type="number" id="prix_unitaire" name="prix_unitaire" step="0.01" required>
                
                <label for="date_achat">Date :</label>
                <input type="date" id="date_achat" name="date_achat" required>
            </fieldset>

            <!-- Informations de paiement -->
            <fieldset>
                <legend>Paiment</legend>

                <label for="mode_paiement">Mode :</label>
                <select id="mode_paiement" name="mode_paiement" required>
                    <option value="carte">Carte bancaire</option>
                    <option value="espece">Espèces</option>
                    <option value="virement">Virement bancaire</option>
                </select>

                <label for="montant_total">Montant total :</label>
                <input type="number" id="montant_total" name="montant_total" step="0.01" required>
            </fieldset>

            <!-- Boutons d'action -->
            <button type="submit">Confirmer</button>
            <button type="reset">Réinitialiser</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Pharmacie. Tous droits réservés.</p>
    </footer>

</body>
</html>
