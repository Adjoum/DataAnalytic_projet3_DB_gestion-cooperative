<?php  
    
    include_once("fonctions.php");   
 
 ?>

 <!DOCTYPE html>
 <html lang="fr">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Benefice</title>
 </head>
 <body>
   <div class="h1-description">
       <h1>Le bénéfice net de l'entreprise </h1>
    </div>
    <?php 
    
    $benefice = benefice() ;
    include_once("close_DB.php");
    echo "<p>Voici le benefice global de l'entreprise : <strong>" . $benefice . "</strong>FCFA" ;

    ?>
    <div>
        <a href="index.php">← Retour</a>
    </div>
 </body>
 </html>