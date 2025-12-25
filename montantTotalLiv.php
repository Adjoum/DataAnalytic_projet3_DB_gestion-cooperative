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
       <h1>Le montant total des livraisons d’un fournisseur à une date donnée </h1>
    </div>
    <form action="" method="get">
        <label for="">Code du fournisseur</label>
        <input type="text" name="CodeF">
        <label for="">Date de livraison</label>
        <input type="text" name="dateLiv" placeholder="Ce format de date: 2021-03-01">
        
        <input type="submit" value="Soumettre" name="montantTotalLiv">
    </form>
    <div>
        <a href="index.php">← Retour</a>
    </div>

    <?php  
        if (isset($_GET["montantTotalLiv"])) {
            if(empty($_GET["CodeF"]) || empty($_GET["dateLiv"])){
                die("<p>Vous devez remplir tous les champs</p>");
            }else{
                $montantTotal = montantTotalLiv(trim($_GET["CodeF"]), trim($_GET["dateLiv"]));
                include_once("close_DB.php");
                
                echo "<p>Le montant total des livraisons à la date du " . $_GET["dateLiv"] . " est de <strong>$montantTotal FCFA</strong>.</p>";

            }   
        }
    ?>
    
</body>
</html>