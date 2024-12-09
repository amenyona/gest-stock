<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat Direct</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h6>Achat Direct chez la pharmacie Saint Joseph</h6>
    <div class="product">
        @foreach ($ventes as $item)
        <p>Nom du Produit</p>
        {{retreiveNomProduit($item['produit_id'])}}
        <p>Quantité</p>
      {{$item['quantité_vendue']}}
        @endforeach
    </div>

    <script src="script.js"></script>
</body>
</html>