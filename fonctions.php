<?php

/*function connexion_to_DB() {
    $DB_Name = 'gestion_commande';
    $DB_Password = '';
    $User_Name = 'root';

    try {
        $DB = new PDO("Mysql:host=$User_Name; dbname=$DB_Name; charset=utf8", $User_Name, $DB_Password);

        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e) {

        die('Un problème est survenu lors de la tentative de connexion à la base de donnée :'. $e->getMessage());
    }

    return $DB;
} */

include_once("connexion_to_DB.php");


function afficherTable($nomTable) {
    global $DB;
    $sql = "SELECT * FROM $nomTable";
    //$DB = connexion_to_DB();
    $query = $DB -> prepare($sql);
    $query -> execute();
    $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);
    return $resultat;
}

function afficherColonneTable($nomTable) {
    global $DB;

    $mesTables = ["adherents", "produits", "commander", "dates", "detailsliv", "fournisseurs"];

    if (!in_array(strtolower($nomTable), $mesTables)) {

        die("<p class='mesgErreur'>Ce nom de table <strong class='formErreur'>". $nomTable."</strong> que tu viens de saisir, n'est pas dans la base de données</p>");

    }else{

        $sql = "DESCRIBE $nomTable";
        $query = $DB -> prepare($sql);
        $query -> execute();
        $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $resultat;
    }
    

}
function nomFournisseur($codeF){
    global $DB;
    //$DB = connexion_to_DB();
    $sql = "SELECT nomFour FROM Fournisseurs WHERE codeFour=:codeF";
    $query = $DB -> prepare($sql);
    $query -> bindParam(':codeF', $codeF, PDO::PARAM_STR);
    $query->execute();
    $resultat = $query -> fetch(\PDO::FETCH_ASSOC);
    return $resultat['nomFour'];

}

function montantLiv($codeF, $refPr, $dateLiv) {
    //$DB = connexion_to_DB();
    global $DB;

    $sql = "SELECT qteLiv, prixAchat FROM detailsliv WHERE codeFour=? AND refProd=? AND dateLiv=?";
    $query = $DB -> prepare($sql);
    $query -> bindParam(1, $codeF, PDO::PARAM_STR) ;
    $query->bindParam(2, $refPr, PDO::PARAM_STR) ;
    $query->bindParam(3, $dateLiv, PDO::PARAM_STR) ;
    $query->execute();
    $resultat = $query->fetch(\PDO::FETCH_ASSOC);
    $calcul = $resultat["qteLiv"]*$resultat["prixAchat"];
    return $calcul;


}

function montantTotalLiv($codeF, $dateLiv) {
    global $DB;
    $sql = "SELECT qteLiv, prixAchat FROM detailsliv WHERE codeFour=? AND dateLiv=?";
    $query = $DB -> prepare($sql);
    $query -> bindParam(1, $codeF, PDO::PARAM_STR) ;
    $query->bindParam(2, $dateLiv, PDO::PARAM_STR) ;
    $query->execute();
    $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);
    $montantTotal=0;
    foreach ($resultat as $row) {
        $calcul = $row["qteLiv"]*$row["prixAchat"];
        $montantTotal += $calcul;
    }
    

    return $montantTotal;
}

function benefice() {

    global $DB;
    $sql = "SELECT produits.prixVente, detailsliv.prixAchat, detailsliv.qteliv
            FROM produits JOIN detailsliv ON produits.refProd = detailsliv.refProd";
    $query = $DB -> prepare($sql);
    $query->execute();
    $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);

    $Vente = 0;
    $Achat = 0;
    
    foreach( $resultat as $row ) {

        $Vente += $row["qteliv"]*$row["prixVente"];
        $Achat += $row["qteliv"]*$row["prixAchat"];
    }

    
    return $Vente - $Achat;
}

function nomFourCher($refPr) {
    global $DB;
    $sql = "SELECT codeFour, dateLiv, prixAchat FROM detailsliv WHERE refProd = :refProd";
    $query = $DB -> prepare($sql);
    $query->bindParam(':refProd', $refPr, PDO::PARAM_STR) ;
    $query->execute();
    $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);
    $prixMax = 0;
    $date = date('Y M d H:m:s');
    $codeF = '';
    foreach( $resultat as $row ) {
        if ($row['prixAchat'] > $prixMax) {
            $prixMax = $row['prixAchat'];
            $date = $row['dateLiv'];
            $codeF = $row['codeFour'];
        }
    
    }
    return [$prixMax, $date, $codeF];
}

function gererStockLiv($codeF, $refPr, $qteLiv) {
    global $DB;
    $sql = "SELECT codeFour, refProd, qteLiv FROM detailsliv WHERE codeFour = ? AND refProd = ? AND qteLiv = ?";
    $query = $DB -> prepare($sql);
    $query->bindParam(1, $codeF, PDO::PARAM_STR) ;
    $query->bindParam(2, $refPr, PDO::PARAM_STR) ;
    $query->bindParam(3, $qteLiv, PDO::PARAM_INT) ;
    $query->execute();
    $resultat = $query->fetchAll(\PDO::FETCH_NUM);
    if (!$resultat) {
        die("<p>L'une ou plusieurs des valeurs entrées ne correspondent aux valeurs qui sont dans la base de données, <br>
        <strong><em>Veillez réessayer avec d'autres entrées corrects SVP !</em></strong></p>");
    }else{
        //$sql = "SELECT detailsliv.$codeF, detailsliv.$refPr, detailsliv.$qteLiv, detailsliv.dateLiv, commmander.$codeF, commander.$refPr, commander.qteCom, commander.dateCom FROM detailsliv JOIN commander ON detailsliv.refProd = commander.refProd";
        $sql_1 = "SELECT qteLiv FROM detailsliv WHERE codeFour = ? AND refProd = ?";
        $query = $DB -> prepare($sql_1);
        $query->bindParam(1, $codeF, PDO::PARAM_STR) ;
        $query->bindParam(2, $refPr, PDO::PARAM_STR) ;
        
        $query->execute();
        $resultat_1 = $query->fetchAll(\PDO::FETCH_ASSOC);

        $somQteLiv = 0;
        foreach( $resultat_1 as $row ) {
            $somQteLiv += $row["qteLiv"];
        }

        return $somQteLiv;
    }

}  

/**
 * Retourne le nom d’un adhérent connaissant son code
 */
function nomAdherent($codeAdh) {
    global $DB;
    $sql = "SELECT nomAdh FROM adherents WHERE numAdh = :codeAdh";
    $query = $DB -> prepare($sql);
    $query->bindParam(":codeAdh", $codeAdh, PDO::PARAM_STR) ;
    $query->execute();
    $resultat = $query->fetch(\PDO::FETCH_ASSOC);
    return $resultat["nomAdh"];

}

/** 
 * Calcul le montant d’une commande à une date donnée
 */
function montantCom($codeAdh, $refPr, $dateCom) {
    global $DB;
    //$sql = "SELECT produits.prixVente, commander.numAdh, commander.refProd, commander.dateCom, commander.qteCom 
    //FROM produits JOIN commander ON produits.$refPr=commander.$refPr";
    $sql = "SELECT qteCom FROM commander WHERE numAdh=? AND refProd=? AND dateCom=?";
    $query = $DB -> prepare($sql);
    $query->bindParam(1, $codeAdh, PDO::PARAM_STR) ;
    $query->bindParam(2, $refPr, PDO::PARAM_STR) ;
    $query->bindParam(3, $dateCom, PDO::PARAM_STR) ;

    $query-> execute();
    $resultat = $query->fetch(\PDO::FETCH_ASSOC);

    $sql1 = "SELECT prixVente FROM produits WHERE refProd=:refPr";
    $query1 = $DB -> prepare($sql1);
    $query1->bindParam("refPr", $refPr, PDO::PARAM_STR) ;
    $query1->execute();
    $resultat1 = $query1->fetch(\PDO::FETCH_ASSOC);
    
    return $resultat["qteCom"]*$resultat1["prixVente"];

    //return $resultat["qteCom"]*$resultat["prixVente"];

}

/**
 * calcule le montant total des commandes d’un adhérent à une date donnée
 */
/*function montantTotalCom($codeAdh, $dateCom) {
    global $DB;
    //$sql = "SELECT produits.prixVente, commander.numAdh, commander.refProd, commander.dateCom, commander.qteCom 
    //FROM produits JOIN commander ON produits.$refPr=commander.$refPr";
    $sql = "SELECT qteCom, refProd FROM commander WHERE numAdh=? AND dateCom=?";
    $query = $DB -> prepare($sql);
    $query->bindParam(1, $codeAdh, PDO::PARAM_STR) ;
    $query->bindParam(2, $dateCom, PDO::PARAM_STR) ;

    $query-> execute();
    $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);

    $sql1 = "SELECT prixVente FROM produits WHERE refProd=:refPr";
    $query1 = $DB -> prepare($sql1);
    $query1->bindParam("refPr", $refPr, PDO::PARAM_STR) ;
    $query1->execute();
    $resultat1 = $query1->fetch(\PDO::FETCH_ASSOC);
    return $resultat["qteCom"]*$resultat1["prixVente"]; 

    //return $resultat["qteCom"]*$resultat["prixVente"];

}  */

function montantTotalCom($codeAdh, $dateCom) {
    global $DB;
    $sql = "SELECT produits.prixVente, commander.refProd, commander.qteCom 
    FROM produits JOIN commander ON produits.refProd=commander.refProd WHERE numAdh=? AND dateCom=?";
    
    $query = $DB -> prepare($sql);
    $query->bindParam(1, $codeAdh, PDO::PARAM_STR) ;
    $query->bindParam(2, $dateCom, PDO::PARAM_STR) ;

    $query-> execute();
    $resultat = $query->fetchAll(\PDO::FETCH_ASSOC);

    $som =0;
    foreach ($resultat as $row) {
     $som += $row["qteCom"]*$row["prixVente"];
    }
    return $som;
}

/**
 * permettant de gérer le stock à chaque commande
 */

function gererStockCom($codeF, $refPr, $qteLiv) {
    global $DB;
    $sql = "SELECT codeFour, refProd, qteLiv FROM detailsliv WHERE codeFour = ? AND refProd = ? AND qteLiv = ?";
    $query = $DB -> prepare($sql);
    $query->bindParam(1, $codeF, PDO::PARAM_STR) ;
    $query->bindParam(2, $refPr, PDO::PARAM_STR) ;
    $query->bindParam(3, $qteLiv, PDO::PARAM_INT) ;
    $query->execute();
    $resultat = $query->fetchAll(\PDO::FETCH_NUM);
    if (!$resultat) {
        die("<p>L'une ou plusieurs des valeurs entrées ne correspondent aux valeurs qui sont dans la base de données, <br>
        <strong><em>Veillez réessayer avec d'autres entrées corrects SVP !</em></strong></p>");
    }else{
        //$sql = "SELECT detailsliv.$codeF, detailsliv.$refPr, detailsliv.$qteLiv, detailsliv.dateLiv, commmander.$codeF, commander.$refPr, commander.qteCom, commander.dateCom FROM detailsliv JOIN commander ON detailsliv.refProd = commander.refProd";
        $sql_1 = "SELECT dateLiv FROM detailsliv WHERE codeFour = ? AND refProd = ? AND qteLiv = ?";
        $query = $DB -> prepare($sql_1);
        $query->bindParam(1, $codeF, PDO::PARAM_STR) ;
        $query->bindParam(2, $refPr, PDO::PARAM_STR) ;
        $query->bindParam(3, $qteLiv, PDO::PARAM_INT) ;
        $query->execute();
        $resultat_1 = $query->fetch(\PDO::FETCH_ASSOC);
        $dateLiv = $resultat_1['dateLiv'];

        $sql_2 = "SELECT qteCom FROM commander WHERE refProd = ? AND dateCom = ?";
        $query = $DB -> prepare($sql_2);
        $query->bindParam(1, $refPr, PDO::PARAM_STR) ;
        $query->bindParam(2, $dateLiv, PDO::PARAM_STR) ;
        $query->execute();
        $resultat_2 = $query->fetchAll(\PDO::FETCH_ASSOC);

        $somQteCom = 0;
        foreach( $resultat_2 as $row ) {
            $somQteCom += $row["qteCom"];
        }

        return $qteLiv - $somQteCom;
    }

} 



/*

Fonction pour traiter les factures

*/

function factureAdh($codeAdh, $date){
    global $DB;
    $sql = "SELECT commander.qteCom AS qte, commander.refProd, commander.dateCom AS dateFact, adherents.nomAdh AS nom, adherents.villeAdh AS ville, produits.nomProd, 
    produits.prixVente AS prix FROM commander JOIN adherents ON adherents.numAdh = commander.numAdh
    JOIN produits ON produits.refProd = commander.refProd WHERE commander.numAdh = ? AND commander.dateCom = ?" ;

    $query = $DB->prepare($sql) ;
    $query->bindParam(1, $codeAdh, PDO::PARAM_STR) ;
    $query->bindParam(2, $date, PDO::PARAM_STR) ;
    $query->execute() ;
    $result = $query->fetchAll(PDO::FETCH_ASSOC) ;
    return $result ;
}

/*$test = factureAdh("A01","2021-01-01") ;

foreach ($test as $key => $ligne) {
    echo "<hr>";
    echo "Commande n° : " . ($key + 1) . "<br>";
    echo "Adhérent : " . $ligne['nomAdh'] . "<br>";
    echo "Ville : " . $ligne['villeAdh'] . "<br>";
    echo "Produit : " . $ligne['nomProd'] . "<br>";
    echo "Quantité : " . $ligne['qteCom'] . "<br>";
    echo "Prix unitaire : " . $ligne['prixVente'] . "<br>";
    echo "Total : " . ($ligne['qteCom'] * $ligne['prixVente']) . " FCFA<br>";
}    */



function factureFour($codeF, $date){
    global $DB;
    $sql = "SELECT detailsliv.qteLiv AS qte, detailsliv.refProd, detailsliv.prixAchat AS prix, detailsliv.dateLiv AS dateFact, fournisseurs.nomFour AS nom, fournisseurs.villeFour AS ville, produits.nomProd 
    FROM detailsliv JOIN fournisseurs ON fournisseurs.codeFour = detailsliv.codeFour
    JOIN produits ON produits.refProd = detailsliv.refProd WHERE detailsliv.codeFour = ? AND detailsliv.dateLiv = ?" ;

    $query = $DB->prepare($sql) ;
    $query->bindParam(1, $codeF, PDO::PARAM_STR) ;
    $query->bindParam(2, $date, PDO::PARAM_STR) ;
    $query->execute() ;
    $result = $query->fetchAll(PDO::FETCH_ASSOC) ;
    return $result ;
}

/*$test1 = factureFour("F01", "2021-01-01");

foreach ($test1 as $key => $ligne) {
    echo "<hr>";
    echo "Livraison n° : " . ($key + 1) . "<br>";
    echo "Fournisseur : " . $ligne['nomFour'] . "<br>";
    echo "Ville : " . $ligne['villeFour'] . "<br>";
    echo "Produit : " . $ligne['nomProd'] . "<br>";
    echo "Quantité : " . $ligne['qteLiv'] . "<br>";
    echo "Prix d'achat : " . $ligne['prixAchat'] . "<br>";
    echo "Total : " . ($ligne['qteLiv'] * $ligne['prixAchat']) . " FCFA<br>";
}  */


function facture( $code, $date ){
   
    if (str_starts_with($code,"F")) {

        factureFour($code, $date);   

    }elseif (str_starts_with($code,"A")) {

       factureAdh($code, $date);

    }else {

        die("Nous ne pouvons traiter ce code : ". $code ." Veillez réessayer avec un vrai code Fourniseur ou Adhérent");
    
    }
}

function genererNumeroCommande($code, $date){
    global $DB, $type;
    
    if ($type == "Adhérent") {
        // Compter le nombre de commandes pour cet adhérent à cette date
        $sql = "SELECT COUNT(*) as total FROM commander WHERE numAdh = ? AND dateCom = ?";
        $req = $DB->prepare($sql);
        $req->execute([$code, $date]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        
        $increment = $result['total'];
        
        // Format: Code + C + numéro incrémenté
        $result = $code . "C" . $increment;
    }elseif ($type == "Fournisseur") {
        // Compter le nombre de livraisons pour ce fournisseur à cette date
        $sql = "SELECT COUNT(DISTINCT refProd) as total FROM detailsliv WHERE codeFour = ? AND dateLiv = ?";
        $req = $DB->prepare($sql);
        $req->execute([$code, $date]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        
        $increment = $result['total'];
        
        // Format: Code + L + numéro incrémenté
        $result = $code . "L" . $increment;
    }
    return $result;
} 



?>