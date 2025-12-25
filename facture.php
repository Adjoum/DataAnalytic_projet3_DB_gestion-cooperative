<?php
include_once("fonctions.php");

$facture = [];
$type = "";
$num = "";

if (!empty($_POST)) {
    $code = trim($_POST['code']);
    $date = $_POST['date'];

    if (str_starts_with($code, "A")) {
        $facture = factureAdh($code, $date);
        $type = "Adhérent";
    } elseif (str_starts_with($code, "F")) {
        $facture = factureFour($code, $date);
        $type = "Fournisseur";
    }
    $num = genererNumeroCommande($code, $date);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Facturation Coopérative</title>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1 class="header-facture">🧾 Facturation Coopérative</h1>
        </div>
        
        <div class="content">
            <!-- FORMULAIRE -->
            <div class="formulaire">
                <form method="post">
                    <input type="text" name="code" placeholder="Code (A01 ou F01)" required>
                    <input type="date" name="date" required>
                    <button type="submit">Éditer la facture</button>
                </form>
                <div>
        <a href="index.php">← Retour</a>
    </div>
            </div>

            <!-- LA FACTURE -->
            <?php if(!empty($facture)): 
                $enteteFact = $facture[0];
                $totalHT = 0;
            ?>

            <div class="facture">

                <!-- ENTREPRISE -->
                <div class="entete">
                    <img src="https://img.freepik.com/vecteurs-premium/image-vectorielle-icone-communaute-peut-etre-utilisee-pour-marketing-influence_120816-253058.jpg?semt=ais_hybrid&w=740&q=80" alt="Logo">
                    <h1>Société Coopérative Union</h1>
                </div>

                <div class="barre"></div>

                <!-- INFOS FACTURE -->
                <div class="infos">
                    <div>
                        <p><strong><em>Type :</em></strong> <?= $type ?></p>
                        <p><strong><?php if($type=='Adhérent'){echo 'Nom Client';}else{echo'Nom Fournisseur';} ?>:</strong> <?= $enteteFact['nom'] ?></p>
                        <p><strong><?php if($type == 'Adhérent'){ echo 'Numero Adh'; }else{ echo 'Numero Four';} ?> :</strong> <?=  $code ?></p>
                        <p><strong><?php if($type=='Adhérent'){echo 'Num Commande :';}else{echo 'Num Livraison :';} ?></strong> <?= $num ?></p>
                    </div>
                    <div>
                        <p><strong>Adresse :</strong> <?= $enteteFact['ville'] ?></p>
                        <p><strong>Date :</strong> <?= date("d/m/Y", strtotime($enteteFact['dateFact'])) ?></p>
                    </div>
                </div>

                <div class="barre"></div>

                <!-- TABLEAU -->
                <table>
                    <tr>
                        <th class="tableHead">Produit acheté</th>
                        <th class="tableHead">Prix unitaire</th>
                        <th class="tableHead">Quantité</th>
                        <th class="tableHead">Montant HT</th>
                    </tr>

                    <?php foreach($facture as $ligne):
                        $montant = $ligne['prix'] * $ligne['qte'];
                        $totalHT += $montant;
                    ?>
                    <tr>
                        <td><?= $ligne['nomProd'] ?></td>
                        <td><?= number_format($ligne['prix'],0,',',' ') ?></td>
                        <td><?= $ligne['qte'] ?></td>
                        <td><?= number_format($montant,0,',',' ') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <?php
                    $tva = 0.18;
                    $totalTTC = $totalHT * (1+$tva);
                    $f = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
                ?>

                <div class="totaux">
                    <p><strong>Total HT :</strong> <?= number_format($totalHT,0,',',' ') ?> FCFA</p>
                    <p><strong>Total TTC :</strong> <?= number_format($totalTTC,0,',',' ') ?> FCFA</p>
                </div>

                <p class="lettres">
                    Arrêtée la présente facture à la somme de :
                    <strong><?= ucfirst($f->format($totalTTC)) ?> francs CFA</strong>
                </p>

            </div>

            <div class="actions">
                <button onclick="window.print()" class="btn btn-info">🖨️ Imprimer</button>
                <a href="index.php" class="btn btn-primary">← Retour à l'accueil</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>