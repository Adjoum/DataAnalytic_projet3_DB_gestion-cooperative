<?php  
    include_once("fonctions.php");   
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestion de stock de livraison</title>
</head>
<body>
       <div class="h1-description">
       <h1>La gestion du stock à chaque livraison </h1>
</div> 
    <form action="" method="get">
        <label for="">Code du fourniseur</label>
        <input type="text" name="CodeF">
        <label for="">Reference du produit (code produit)</label>
        <input type="text" name="refProd">
        <label for="">Quantité de livraison</label>
        <input type="number" name="qteLiv">
        <input type="submit" value="Soumettre" name="gererStockCom">
    </form>

    <div>
        <a href="index.php">← Retour</a>
    </div>
    <?php  
        if (isset($_GET["gererStockCom"])) {
            if(empty($_GET["CodeF"]) || empty($_GET["refProd"]) || empty($_GET["qteLiv"])){
                die("<p>Vous devez remplir tous les champs</p>");
            }
            else{
            $stockCom = gererStockLiv(trim($_GET["CodeF"]), trim($_GET["refProd"]), trim($_GET["qteLiv"]));
            include_once("close_DB.php");
            }   
        
            echo "<p>Le stock de livraison  disponible pour cette référence est de <strong>$stockCom</strong>.</p>";

        }

    ?>
</body>
</html>