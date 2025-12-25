---
title: "Projet 3 : Gestion d'une Coopérative"
subtitle: "Système de Gestion Intégré"

author:
  - "GUEI Jean Michel"
  - "TOURE Awa"
  - "ADJOUMANI Koffi Wilfried"
  - "DJATCHI Gnahoua Junior"
  - "SAVANE Syndou"

date: "Décembre 2025"
institute: "INP-HB - Formation Data Analyst Industriel"
supervisor: "K. M. BROU"

lang: fr
documentclass: report
papersize: a4
fontsize: 12pt

geometry:
  top: 25mm
  bottom: 25mm
  left: 30mm
  right: 25mm

linestretch: 1.5

toc: true
toc-depth: 3
toc-title: "Table des Matières"
numbersections: true

colorlinks: true
linkcolor: blue
urlcolor: blue
citecolor: green
toccolor: black

header-includes: |
  \usepackage{fancyhdr}
  \pagestyle{fancy}
  \fancyhead[L]{Projet 3 - Gestion Coopérative}
  \fancyhead[R]{INP-HB 2025-2026}
  \fancyfoot[C]{\thepage}
  \usepackage{xcolor}
  \definecolor{myblue}{RGB}{52, 152, 219}
  \usepackage{listings}
  \lstset{
    basicstyle=\ttfamily\small,
    breaklines=true,
    backgroundcolor=\color{gray!10},
    frame=single,
    rulecolor=\color{myblue}
  }
  \usepackage{graphicx}
  \usepackage{float}
  \usepackage{booktabs}

titlepage: true
titlepage-rule-color: "3498db"
titlepage-rule-height: 4
titlepage-background: "background.pdf"

links-as-notes: false
---

# RAPPORT DE PROJET
## Projet 3 : Gestion d'une Coopérative

---

**Formation :** Data Analyst Industriel  
**Année Universitaire :** 2025-2026  
**Date de soumission :** Décembre 2025  
**Encadreur :** K. M. BROU

---

## MEMBRES DU GROUPE

1. GUEI JEAN MICHEL
2. TOURE AWA
3. ADJOUMANI KOFFI WILFRIED
4. DJATCHI GNAHOUA JUNIOR
5. SAVANE SYNDOU

---

## TABLE DES MATIÈRES

1. Introduction
2. Schéma Relationnel
3. Création de la Base de Données
4. Fonctions Métier Implémentées
5. Interface Web
6. Tests et Résultats
7. Déploiement du Projet
8. Conclusion

---

## 1. INTRODUCTION

### 1.1 Contexte du Projet

Ce projet consiste à développer un système de gestion pour une coopérative qui gère les commandes des adhérents et les livraisons des fournisseurs. Le système permet de suivre les stocks, calculer les bénéfices et éditer des factures.

### 1.2 Objectifs

- Créer une base de données relationnelle pour gérer les adhérents, fournisseurs, commandes et produits
- Développer des fonctions PHP pour les opérations métier
- Créer une interface web pour la gestion et l'édition de factures
- Assurer le suivi des stocks et des transactions

### 1.3 Technologies Utilisés

- **SGBD :** MySQL V8.0.43
- **Langage :** PHP V8.2.28
- **Interface :** PDO (PHP Data Object)
- **Serveur Web :** Apache/WAMPSERVER
- **Front-end :** HTML5, CSS3, JavaScript
- **IDE :** VS CODE


## Choix du Moteur de Stockage de MySQL

### Justification Technique

Le moteur de stockage **InnoDB** a été choisi pour ce projet pour les raisons suivantes :

#### 1. **Support des Transactions ACID**
InnoDB garantit l'intégrité des données grâce aux propriétés ACID (Atomicité, Cohérence, Isolation, Durabilité). Ceci est crucial pour notre système de gestion de coopérative où les opérations de commandes et livraisons doivent être fiables et cohérentes.

#### 2. **Gestion des Clés Étrangères**
InnoDB supporte nativement les contraintes de clés étrangères (`FOREIGN KEY`), essentielles pour maintenir l'intégrité référentielle entre nos tables (adherents, fournisseurs, produits, commander, detailsliv). Cela empêche les insertions ou suppressions incohérentes.

#### 3. **Verrouillage au Niveau Ligne**
Contrairement à MyISAM qui verrouille toute la table, InnoDB utilise un verrouillage au niveau des lignes. Cela améliore les performances lors d'accès concurrents, permettant à plusieurs utilisateurs de travailler simultanément sur différentes lignes de la même table.

#### 4. **Récupération Automatique après Crash**
InnoDB dispose d'un mécanisme de journalisation (transaction logs) qui permet une récupération automatique des données en cas de panne du serveur, garantissant ainsi la pérennité des informations de la coopérative.

#### 5. **Performances Optimisées**
InnoDB utilise un système de cache sophistiqué (Buffer Pool) qui améliore significativement les performances pour les opérations de lecture/écriture fréquentes, typiques dans un système de gestion de coopérative.

### Comparaison avec MyISAM

| Critère | InnoDB | MyISAM |
|---------|--------|--------|
| Transactions | ✅ Oui | ❌ Non |
| Clés étrangères | ✅ Oui | ❌ Non |
| Verrouillage | Niveau ligne | Niveau table |
| Récupération crash | ✅ Automatique | ⚠️ Manuelle |
| Intégrité données | ✅ Forte | ⚠️ Faible |

#### Par conséquent, 

Le choix d'InnoDB assure la **fiabilité**, la **cohérence** et les **performances** nécessaires pour un système de gestion de coopérative professionnel, tout en garantissant l'intégrité des données financières et transactionnelles critiques.
## 2. SCHÉMA RELATIONNEL

### 2.1 Tables de la Base de Données

```
ADHERENTS (numAdh, nomAdh, villeAdh, telAdh, emailAdh)
Clé primaire : numAdh

FOURNISSEURS (codeFour, nomFour, villeFour, telFour, emailFour)
Clé primaire : codeFour

PRODUITS (refProd, nomProd, prixVente)
Clé primaire : refProd

DATES (date)
Clé primaire : date

COMMANDER (numAdh, refProd, dateCom, qteCom, numCom)
Clés primaires : numAdh, refProd, dateCom
Clés étrangères : 
  - numAdh → ADHERENTS(numAdh)
  - refProd → PRODUITS(refProd)
  - dateCom → DATES(date)

DETAILSLIV (codeFour, refProd, dateLiv, qteLiv, prixAchat, numLiv)
Clés primaires : codeFour, refProd, dateLiv
Clés étrangères :
  - codeFour → FOURNISSEURS(codeFour)
  - refProd → PRODUITS(refProd)
  - dateLiv → DATES(date)
```

### 2.2 Diagramme de Dépendances Fonctionnelles

- numAdh → nomAdh, villeAdh, telAdh, emailAdh
- codeFour → nomFour, villeFour, telFour, emailFour
- refProd → nomProd, prixVente
- (numAdh, refProd, dateCom) → qteCom, numCom
- (codeFour, refProd, dateLiv) → qteLiv, prixAchat, numLiv

---

## 3. CRÉATION DE LA BASE DE DONNÉES & Alimentation de la Base de Données


### Méthodologie Adoptée

#### 1. **Analyse des Tables**
Étude approfondie de la structure des tables (adherents, fournisseurs, produits, commander, detailsliv) pour comprendre les relations et les contraintes d'intégrité.

#### 2. **Conception du Schéma**
Création du schéma relationnel avec définition des clés primaires, clés étrangères et contraintes d'intégrité référentielle. Aussi, nous avons défini des index afin de faciliter et optimiser les requêtes dans notre BD.

#### 3. **Nettoyage des Données**
- Correction des valeurs aberrantes (quantités invalides)
- Normalisation des formats (dates)
- Vérification de la cohérence inter-tables

#### 4. **Insertion des Données**
Utilisation de requêtes SQL `INSERT INTO` en respectant l'ordre des dépendances :
```sql
1. Tables indépendantes : adherents, fournisseurs, produits, dates
2. Tables dépendantes : commander, detailsliv
```

Cette approche méthodique a garanti l'intégrité et la cohérence des données dès l'initialisation du système.


### Script de Création

```sql
DROP DATABASE IF EXISTS Gestion_cooperative;
CREATE DATABASE Gestion_cooperative;

USE Gestion_cooperative;

--Table ADHERENTS
CREATE TABLE IF NOT EXISTS Adherents(
    numAdh VARCHAR(10) PRIMARY KEY NOT NULL,
    nomAdh VARCHAR(50) NOT NULL,
    villeAdh VARCHAR(50) NOT NULL,
    telAdh INT(10) NULL,
    emailAdh VARCHAR(50) NULL
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE UNIQUE INDEX index_numAdh ON Adherents(numAdh, nomAdh, villeAdh, telAdh, emailAdh);


-- Table FOURNISSEURS
CREATE TABLE IF NOT EXISTS Fournisseurs(
    codeFour VARCHAR(10) PRIMARY KEY NOT NULL,
    nomFour VARCHAR(50) NOT NULL,
    villeFour VARCHAR(50) NOT NULL,
    telFour INT(10) NULL,
    emailFour VARCHAR(50) NULL
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
CREATE UNIQUE INDEX index_codeFour ON Fournisseurs(codeFour, nomFour, villeFour, telFour, emailFour);

-- Table PRODUITS
CREATE TABLE IF NOT EXISTS Produits(
    refProd VARCHAR(10) PRIMARY KEY NOT NULL,
    nomProd VARCHAR(50) NOT NULL,
    prixVente INT(10) NOT NULL
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE UNIQUE INDEX index_refProd ON Produits(refProd, nomProd, prixVente); 

-- Table DATES
CREATE TABLE IF NOT EXISTS Dates(
    dates TIMESTAMP PRIMARY KEY
    )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table COMMANDER
CREATE TABLE IF NOT EXISTS Commander(
    numAdh VARCHAR(10) NOT NULL,
    refProd VARCHAR(10) NOT NULL,
    dateCom TIMESTAMP NOT NULL,
    qteCom INT NOT NULL,
    
    CONSTRAINT contraintnumAdh 
        FOREIGN KEY (numAdh) REFERENCES Adherents(numAdh)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    
    CONSTRAINT contraintrefProd
        FOREIGN KEY (refProd) REFERENCES Produits(refProd)
        ON UPDATE CASCADE
        ON DELETE CASCADE
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;  

-- Table DETAILSLIV
CREATE TABLE IF NOT EXISTS DetailsLiv(
    codeFour VARCHAR(10) NOT NULL,
    refProd VARCHAR(10) NOT NULL,
    dateLiv TIMESTAMP NOT NULL,
    qteLiv INT(10) NOT NULL,
    prixAchat INT NOT NULL,
    CONSTRAINT contraintcodeFour FOREIGN KEY (codeFour) REFERENCES Fournisseurs(codeFour)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    
    CONSTRAINT contrainterefProd FOREIGN KEY (refProd) REFERENCES Produits(refProd)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

### 3.2 Insertion des Données

Les données ont été insérées conformément aux tables fournies dans le cahier des charges (voir annexe).

---

## 4. FONCTIONS MÉTIER IMPLÉMENTÉES

### 4.1 Fonctions pour les Fournisseurs

#### a) nomFournisseur(codeF)
**Description :** Retourne le nom d'un fournisseur connaissant son code

**Code :**
```php
function nomFournisseur($codeF){
    global $DB;
    $sql = "SELECT nomFour FROM Fournisseurs WHERE codeFour=:codeF";
    $query = $DB->prepare($sql);
    $query->bindParam(':codeF', $codeF, PDO::PARAM_STR);
    $query->execute();
    $resultat = $query->fetch(PDO::FETCH_ASSOC);
    return $resultat['nomFour'];
}
```

#### b) montantLiv(codeF, refPr, dateLiv)
**Description :** Calcule le montant d'une livraison à une date donnée

**Formule :** Montant = qteLiv × prixAchat

#### c) montantTotalLiv(codeF, dateLiv)
**Description :** Calcule le montant total des livraisons d'un fournisseur à une date donnée

**Logique :** Somme de tous les montants de livraison pour un fournisseur à une date

#### d) nomFourCher(refPr)
**Description :** Retourne le code du fournisseur le plus cher pour un produit donné

**Résultat :** [prixMax, date, codeFour]

### 4.2 Fonctions pour les Adhérents

#### a) nomAdherent(codeAdh)
**Description :** Retourne le nom d'un adhérent connaissant son code

#### b) montantCom(codeAdh, refPr, dateCom)
**Description :** Calcule le montant d'une commande à une date donnée

**Formule :** Montant = qteCom × prixVente

#### c) montantTotalCom(codeAdh, dateCom)
**Description :** Calcule le montant total des commandes d'un adhérent à une date donnée

### 4.3 Fonctions de Gestion

#### a) benefice()
**Description :** Calcule le bénéfice global de l'entreprise

**Formule :** Bénéfice = Total Ventes - Total Achats

**Code :**
```php
function benefice() {
    global $DB;
    $sql = "SELECT produits.prixVente, detailsliv.prixAchat, detailsliv.qteliv
            FROM produits JOIN detailsliv 
            ON produits.refProd = detailsliv.refProd";
    $query = $DB->prepare($sql);
    $query->execute();
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $Vente = 0;
    $Achat = 0;
    
    foreach($resultat as $row) {
        $Vente += $row["qteliv"] * $row["prixVente"];
        $Achat += $row["qteliv"] * $row["prixAchat"];
    }
    
    return $Vente - $Achat;
}
```

#### b) gererStockLiv(codeF, refPr, qteLiv)
**Description :** Permet de gérer le stock à chaque livraison

**Logique :** Calcule la somme des quantités livrées pour un produit

#### c) gererStockCom(codeF, refPr, qteLiv)
**Description :** Permet de gérer le stock à chaque commande

**Logique :** Stock disponible = qteLiv - somme(qteCom)

### 4.4 Fonctions de Facturation

#### a) factureAdh(codeAdh, date)
**Description :** Récupère les informations nécessaires pour éditer une facture adhérent

**Données retournées :** 
- Informations adhérent (nom, ville)
- Liste des produits commandés
- Quantités et prix

#### b) factureFour(codeF, date)
**Description :** Récupère les informations nécessaires pour éditer une facture fournisseur

#### c) genererNumeroCommande(code, date)
**Description :** Génère automatiquement un numéro de commande/livraison

**Format :** 
- Adhérent : CodeC{increment} (ex: A01C1)
- Fournisseur : CodeL{increment} (ex: F01L1)

---

## 5. INTERFACE WEB

### 5.1 Page d'Accueil (index.php)

L'interface principale propose un menu avec les fonctionnalités suivantes :

- Affichage des tables
- Gestion des stocks (commandes et livraisons)
- Calcul des montants
- Recherche d'informations
- Édition de factures

### 5.2 Édition de Factures

#### Fonctionnalités :
- Saisie du code adhérent/fournisseur
- Sélection de la date
- Génération automatique de la facture

#### Éléments de la Facture :
1. **En-tête** : Logo et nom de l'entreprise
2. **Informations client/fournisseur** :
   - Numéro
   - Nom
   - Adresse
   - Numéro de commande/livraison
   - Date
3. **Tableau des produits** :
   - Produit acheté
   - Prix unitaire
   - Quantité
   - Montant HT
4. **Totaux** :
   - Total HT
   - Total TTC (TVA 18%)
5. **Montant en lettres**

### 5.3 Design et Ergonomie

- Interface responsive et moderne
- Navigation intuitive
- Affichage clair des informations
- Impression facilitée des factures
- Formulaires validés

---

## 6. TESTS ET RÉSULTATS

### 6.1 Tests des Fonctions

| Fonction | Paramètres Testés | Résultat Attendu | Résultat Obtenu | Statut |
|----------|------------------|------------------|-----------------|---------|
| nomFournisseur | F01 | Toto | Toto | ✓ |
| montantLiv | F01, P01, 2021-01-01 | 30000 | 30000 | ✓ |
| montantTotalLiv | F01, 2021-01-01 | 342500 | 342500 | ✓ |
| benefice | - | Calcul correct | Calcul correct | ✓ |
| nomAdherent | A01 | Koffi | Koffi | ✓ |
| montantCom | A01, P01, 2021-01-01 | 36000 | 36000 | ✓ |
| montantTotalCom | A01, 2021-01-01 | 104525 | 104525 | ✓ |
| gererStockLiv | F01, P01, 120 | Stock calculé | Stock calculé | ✓ |
| gererStockCom | F01, P01, 120 | Stock restant | Stock restant | ✓ |

### 6.2 Exemple de Facture Générée

**Société Coopérative Union**

```
Type : Fournisseur                   Adresse : Abidjan
Nom Fournisseur: Froto                    
Numero Four : F02                                
Num Livraison : F02L4                Date : 01/01/2021

┌─────────────────┬──────────────┬──────────┬────────────┐
│ Produit acheté  │ Prix unit.   │ Quantité │ Montant HT │
├─────────────────┼──────────────┼──────────┼────────────┤
│ CD              │ 275          │ 210      │ 57 750     │
│ Sac ordi        │ 15 000       │ 870      │ 13 050 000 │
│ Tablette PC     │ 350 000      │ 430      │ 150 500 000│
│ USB 8 Go        │ 3 000        │ 560      │ 1 680 000  │          
└─────────────────┴──────────────┴──────────┴────────────┘

Total HT : 165 287 750 FCFA
Total TTC : 195 039 545 FCFA

Arrêtée la présente facture à la somme de :
Cent quatre-vingt-quinze millions trente-neuf mille cinq cent quarante-cinq francs CFA toutes taxes comprises.
```

### 6.3 Vérification des Contraintes d'Intégrité

- ✓ Clés primaires uniques respectées
- ✓ Clés étrangères validées
- ✓ Contraintes de non-nullité appliquées
- ✓ Intégrité référentielle maintenue

---


## 7. Déploiement du Projet

### 1. **Versioning sur GitHub**

Le projet a été versionné sur GitHub pour assurer la traçabilité et la collaboration :
```bash
# Initialisation du dépôt Git
git init
git add .
git commit -m "Initial commit: Projet Gestion Coopérative"

# Liaison avec GitHub
git remote add origin https://github.com/Adjoum/DataAnalytic_projet3_DB_gestion-cooperative.git
git push -u origin main
```

**Dépôt GitHub :** `https://github.com/Adjoum/DataAnalytic_projet3_DB_gestion-cooperative`

### 2. **Hébergement sur InfinityFree**

#### Configuration de l'Environnement
- **Plateforme :** InfinityFree (hébergement gratuit PHP/MySQL)
- **URL de production :** `https://gestion-cooperative.great-site.net/`
- **Base de données :** MySQL via phpMyAdmin

#### Étapes de Déploiement

1. **Création du compte** et configuration du site sur InfinityFree
2. **Création de la base MySQL** et récupération des credentials (hostname, username, password)
3. **Import de la base** via phpMyAdmin (fichiers schema.sql et data.sql)
4. **Upload des fichiers** PHP via FileZilla (FTP) dans le dossier `/htdocs/`
5. **Configuration de la connexion** : adaptation du fichier `connexion_to_DB.php` avec les paramètres InfinityFree
6. **Tests fonctionnels** : vérification de toutes les fonctionnalités en production

#### Adaptation Serveur
```php
// Configuration InfinityFree
$DB_Name = '....';
$ServerName = 'sql303.infinityfree.com';
$User_Name = '.....';
$DB_Password = '....';
```

#### Optimisations Appliquées
- Utilisation de `DATE()` dans les requêtes SQL pour la compatibilité des dates
- Gestion des erreurs PDO pour le débogage en production
- Configuration du fichier `.htaccess` pour la performance et la sécurité

Le projet est désormais accessible publiquement et prêt pour la démonstration dans trois jours.


## 8. CONCLUSION

### 8.1 Objectifs Atteints

Le projet de gestion de coopérative a été réalisé avec succès. Toutes les fonctionnalités demandées ont été implémentées et testées :

✓ Base de données créée avec toutes les tables et contraintes  
✓ Toutes les fonctions métier développées et fonctionnelles  
✓ Interface web intuitive et professionnelle  
✓ Édition de factures complète avec numérotation automatique  
✓ Gestion des stocks opérationnelle  
✓ Calcul du bénéfice global de l'entreprise  

### 8.2 Compétences Acquises

- Conception de bases de données relationnelles
- Utilisation de PDO pour la connexion à la BD
- Utilisation des requêtes préparées de PHP pour la sécurité des requêtes
- Développement d'interfaces web professionnelles basique
- Utilisation parfaite des JOINTURES SQL, des contraintes d'intégrité
- Utilisation parfaite de la classe :
  `$f = new NumberFormatter("fr", NumberFormatter::SPELLOUT);` pour convertir les nombres en lettres
- Gestion de projets en équipe
- Tests et validation de fonctionnalités
- Révision en temps record pour certaines technologies: PHP, HTML, CSS, JS

### 8.3 Améliorations Possibles

- Ajout d'un système d'authentification
- Tableau de bord avec statistiques graphiques
- Export des factures en PDF
- Historique des modifications
- Gestion des utilisateurs avec rôles
- Notifications par email

### 8.4 Difficultés Rencontrées

- Gestion de la numérotation automatique des commandes
- Calcul du stock disponible avec multiples livraisons
- Mise en forme professionnelle des factures
- Conversion des montants en lettres en français

---

## ANNEXES

### Annexe A : Structure de la Base de Données

Tables détaillées avec types de données et contraintes

### Annexe B : Code Source Complet
#### Structure du projet
Fichiers PHP disponibles :
```
cooperative/
├── index.php
├── connexion_to_DB.php
├── close_DB.php
├── fonctions.php
├── afficherTable.php
├── benefice.php
├── gererStockCom.php
├── gererStockLiv.php
├── montantCom.php
├── montantLiv.php
├── montantTotalCom.php
├── montantTotalLiv.php
├── nomAdherent.php
├── facture.php
├── nomFournisseur.php
├── nomFourCher.php
├── styles.css
├── sql/
│   ├── schema.sql
│   └── data.sql
├── docs/
│   ├── rapport.pdf
│   └── screenshots/
├── .gitignore
├── README.md
└── LICENSE
```


### Annexe C : Manuel Utilisateur

Instructions pour l'utilisation du système

---

**Fin du Rapport**

*Ce rapport a été rédigé dans le cadre du Projet 3 : Gestion d'une Coopérative*  
*Formation Data Analyst Industriel -INPHB - Année 2025-2026*