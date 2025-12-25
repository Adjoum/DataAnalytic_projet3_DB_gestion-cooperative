<?php  
    
    include_once("fonctions.php");   
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Fourniseur le plus Cher</title>
</head>
<body>
    <div class="h1-description">
       <h1>Le fournisseur le plus cher pour un produit donné </h1>
    </div>
    <form action="" method="get">
        <label for="">Code du fournieur</label>
        <input type="text" name="refProd">
        <input type="submit" name="fournisseurCher">
    </form>
    <div>
        <a href="index.php">← Retour</a>
    </div>
    <?php  
    
    if(isset($_GET["fournisseurCher"])){
        if($_GET["refProd"] == ""){
            die("<p>Donnez le code du produit dont vous voulez savoir le fournisseur le plus cher</p>");
        }else{
            [$prixMax, $date, $codeF] = nomFourCher(trim($_GET["refProd"]));

            include_once("close_DB.php");
        }
        
        echo "<p>Voici le prix le plus élévé <strong>" . $prixMax . " FCFA</strong> à la date du " . $date . " dont le fournisseur est : " . $codeF . "</p>";
        
    }
    
    ?>
</body>
</html>