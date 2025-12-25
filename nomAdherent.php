<?php  
    
    include_once("fonctions.php");   
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Nom adherent</title>
</head>
<body>
    <div class="h1-description">
       <h1>Le nom d’un adhérent connaissant son code </h1>
    </div>
    <form action="" method="get">
        <label for="">Code du fournieur</label>
        <input type="text" name="codeAdh">
        <input type="submit" name="afficheNomAdherent">
    </form>
    <div>
        <a href="index.php">← Retour</a>
    </div>
    <?php  
    
    if(isset($_GET["afficheNomAdherent"])){
        if($_GET["codeAdh"] == ""){
            die("<p>Donnez le code de l'adhérent dont vous souhaiterez afficher le nom</p>");
        }else{
            $nomAdh = nomAdherent(trim($_GET["codeAdh"]));

            include_once("close_DB.php");
        }
        echo "<p>Le nom de l’adhérent correspondant au code <strong>" . $_GET["codeAdh"] . "</strong> est : <strong>$nomAdh</strong>.</p>";
    }
    
    ?>
</body>
</html>