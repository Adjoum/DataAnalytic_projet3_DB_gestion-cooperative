<?php
include_once("fonctions.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestion Coopérative - Accueil</title>
</head>
<body>
    <!-- Menu de navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <h1 class="logo">Gestion Coopérative</h1>
        </div>
    </nav>

    <div class="menu-dashboard">

        <!-- COLONNE LIVRAISONS -->
        <div class="menu-section livraisons">
            <h3>🚛 Livraisons</h3>
            <ul class="menu-principal">
                <li><a href="gererStockLiv.php">📦 Gérer stock livraison</a></li>
                <li><a href="montantLiv.php">💴 Montant livraison</a></li>
                <li><a href="montantTotalLiv.php">📈 Montant total livraison</a></li>
                <li><a href="nomFournisseur.php">🏭 Nom fournisseur</a></li>
                <li><a href="nomFourCher.php">💎 Fournisseur le plus cher</a></li>
            </ul>
        </div>

        <!-- COLONNE COMMANDES -->
        <div class="menu-section commandes">
            <h3>📦 Commandes</h3>
            <ul class="menu-principal">
                <li><a href="gererStockCom.php">🛒 Gérer stock commande</a></li>
                <li><a href="montantCom.php">💰 Montant commande</a></li>
                <li><a href="montantTotalCom.php">📶 Montant total commande</a></li>
                <li><a href="nomAdherent.php"> 🤵🏿‍♂️Nom adhérent</a></li>
            </ul>
        </div>

    </div>

    <!-- AUTRES EN BAS -->
    <div class="menu-section autres">
        <h3>🛠️ Autres fonctionnalités</h3>
        <ul class="menu-principal">
            <li><a href="afficherTable.php">🗃️ Voir les tables</a></li>
            <li><a href="benefice.php">💹 Bénéfice net</a></li>
            <li><a href="facture.php">📑 Éditer une facture</a></li>
        </ul>
    </div>

</body>
</html>