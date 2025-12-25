<?php  
    
    include_once("fonctions.php");   
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Montant d'une commande</title>
</head>
<body>
    <div class="h1-description">
       <h1>Le montant d’une commande à une date donnée</h1>
    </div>
    <form action="" method="get">
        <label for="">Code de l'adhérent</label>
        <input type="text" name="CodeAdh">
        <label for="">Date de commande</label>
        <input type="text" name="dateCom" placeholder="Ce format de date: 2021-03-01">
        <label for="">Reférence du produit (Code du produit)</label>
        <input type="text" name="refProd">
        <input type="submit" value="Soumettre" name="montantCom">
    </form>

    <div>
        <a href="index.php">← Retour</a>
    </div>
    <?php  
        if (isset($_GET["montantCom"])) {
            if(empty($_GET["CodeAdh"]) || empty($_GET["dateCom"]) || empty($_GET["refProd"])){
                die("<p>Vous devez remplir tous les champs</p>");
            }else{
                $montant = montantCom(trim($_GET["CodeAdh"]), trim($_GET["refProd"]), trim($_GET["dateCom"]));
                include_once("close_DB.php");
            }   
        
            echo "<p>Voici le montant de la commande : <strong>". $montant . " FCFA</strong> à la date du : " . $_GET["dateCom"] . "</p>" ;
        }

    ?>
</body>
</html>