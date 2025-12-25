<?php  
    
    include_once("fonctions.php");   
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Nom fournisseur</title>
</head>
<body>
    <div class="h1-description">
       <h1>Le nom d’un fournisseur connaissant son code</h1>
    </div>
    <form action="" method="get">
        <label for="">Code du fournieur</label>
        <input type="text" name="codeF">
        <input type="submit" name="afficheNomFournisseur">
    </form>
    <div>
        <a href="index.php">← Retour</a>
    </div>
    <?php  
    
    if(isset($_GET["afficheNomFournisseur"])){
        if($_GET["codeF"] == ""){
            die("<p>Donnez le code du fournisseur dont vous souhaiterez afficher le nom</p>");
        }else{
            $nomF = nomFournisseur(trim($_GET["codeF"]));

            include_once("close_DB.php");
        }
        
        echo "<p>Le nom du fournisseur correspondant au code <strong>" . $_GET["codeF"] . "</strong> est : <strong>$nomF</strong>.</p>";


    }
    
    ?>
</body>
</html>