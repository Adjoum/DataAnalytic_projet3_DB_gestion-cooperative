<?php  
    
    include_once("fonctions.php");   
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Montant total de livraison</title>
</head>
<body>
    <div class="h1-description">
       <h1>Le montant d’une livraison à une date donnée </h1>
    </div>
    <form action="" method="get">
        <label for="">Code du fournisseur</label>
        <input type="text" name="CodeF">
        <label for="">Reférence du produit (Code produit)</label>
        <input type="text" name="refProd">
        <label for="">Date de livraison</label>
        <input type="text" name="dateLiv" placeholder="Ce format de date: 2021-03-01">
        
        <input type="submit" value="Soumettre" name="montantLiv">
    </form>

    <div>
        <a href="index.php">← Retour</a>
    </div>
    
    <?php  
        if (isset($_GET["montantLiv"])) {
            if(empty($_GET["CodeF"]) || empty($_GET["dateLiv"]) || empty($_GET["refProd"])){
                die("<p>Vous devez remplir tous les champs</p>");
            }
            else{
                $montantLiv = montantLiv(trim($_GET["CodeF"]), trim($_GET["refProd"]), trim($_GET["dateLiv"]));
                include_once("close_DB.php");
                echo "<p>Le montant de la livraison à la date du " . $_GET["dateLiv"] . " est de <strong>$montantLiv FCFA</strong>.</p>";

            }   
        }
    ?>
    
</body>
</html>