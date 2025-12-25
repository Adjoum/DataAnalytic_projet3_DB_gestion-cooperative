<?php  
    
    include_once("fonctions.php");   
    
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Le montant total des commandes d’un adhérent à une date donnée</title>
</head>
<body>
   <div class="h1-description">
       <h1>Le montant total des commandes </h1>
    </div>
    <form action="" method="get">
        <label for="">Code de l'adhérent</label>
        <input type="text" name="CodeAdh">
        <label for="">Date de commande</label>
        <input type="text" name="dateCom" placeholder="Ce format de date: 2021-03-01">
        
        <input type="submit" value="Soumettre" name="montantTotalCom">
    </form>
    
    <div>
        <a href="index.php">← Retour</a>
    </div>

    <?php  
        if (isset($_GET["montantTotalCom"])) {
            if(empty($_GET["CodeAdh"]) || empty($_GET["dateCom"])){
                die("<p>Vous devez remplir tous les champs</p>");
            }else{
            $montantTotal = montantTotalCom(trim($_GET["CodeAdh"]), trim($_GET["dateCom"]));
            include_once("close_DB.php");
            }   
        
            echo "<p>Voici le montant total de la commande : <strong>". $montantTotal . " FCFA</strong> à la date du : " . $_GET["dateCom"] . "</p>" ;
        }

    ?>
</body>
</html>