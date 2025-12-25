<?php  
    
    include_once("fonctions.php");   
    
?>


<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestion d'une coopérative</title>

</head>

<body>

    <form action="" method="get" id="Formateur">
        <div>
            <label for="NomTable"><strong>Donnez le nom de la table dont vous souhaiterai afficher</strong></label> <br>
            <input type="text" name="nomTable" class="nomTable">
        </div>
        <div>
            <input type="submit" name="Table">
        </div>
    </form>
    <div class="espace">

    </div>
    <div>
        <a href="index.php">← Retour</a>
    </div>
    <?php   
    
        if (isset($_GET["Table"])) {

            if (empty($_GET["nomTable"])) {
                die("<div class='errorVide'><strong>Vous devriez spécifier un nom de table dans le champ de saisi ! </strong></div>");
            }else{

                $getColumn = afficherColonneTable(trim($_GET["nomTable"]));
                $getData = afficherTable(trim($_GET["nomTable"]));
                
                include_once("close_DB.php");
            }
            echo "<table>
                <h1 id='titreh1'>Gestion coopérative table : ". strtoupper($_GET['nomTable']). "</h1>
                <thead class='tableHead'>";

                    foreach($getColumn as $col) {
                        echo "<th>".$col["Field"]."</th>";
                    }
            
                echo "</thead>

                <tbody class='tableBody'> ";

                    foreach($getData as $row){

                        echo "<tr>";

                            foreach($row as $value) {

                                echo "<td>".$value."</td>";

                            }

                        echo "</tr>";

                        } 

                echo "</tbody>

            </table> ";
        
        }
       
    ?>

</body>

</html>