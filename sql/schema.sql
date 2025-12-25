DROP DATABASE IF EXISTS Gestion_cooperative;
CREATE DATABASE Gestion_cooperative;

USE Gestion_cooperative;

CREATE TABLE IF NOT EXISTS Adherents(
    numAdh VARCHAR(10) PRIMARY KEY NOT NULL,
    nomAdh VARCHAR(50) NOT NULL,
    villeAdh VARCHAR(50) NOT NULL,
    telAdh INT(10) NULL,
    emailAdh VARCHAR(50) NULL
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE UNIQUE INDEX index_numAdh ON Adherents(numAdh, nomAdh, villeAdh, telAdh, emailAdh);

INSERT INTO Adherents(numAdh, nomAdh, villeAdh, telAdh, emailAdh)
VALUES
('A01', 'Koffi', 'Yakro', 30640506, 'kofy@toto.ci'),
('A02', 'Bintou', 'Abidjan', 21232425, 'bintou@yahoo.fr'),
('A03', 'Adjoua', 'Yakro', 30641515, NULL),
('A04', 'Baba', 'Bouake', 31632526, 'baba@toto.ci'),
('A05', 'Papi', 'Yakro', 30641719,NULL);

CREATE TABLE IF NOT EXISTS Produits(
    refProd VARCHAR(10) PRIMARY KEY NOT NULL,
    nomProd VARCHAR(50) NOT NULL,
    prixVente INT(10) NOT NULL
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
CREATE UNIQUE INDEX index_refProd ON Produits(refProd, nomProd, prixVente);   

INSERT INTO Produits(refProd, nomProd, prixVente)
VALUES
('P01', 'CD', 300),
('P02', 'DVD', 100),
('P03', 'USB 4 Go', 2000),
('P04', 'USB 8 Go', 4000),
('P05', 'DD 1 To', 30000),
('P06', 'Souris', 5000),
('P07', 'Sac ordi', 20000),
('P08', 'Tablette PC', 400000),
('P09', 'Laptop', 300000),
('P10', 'Printer', 20000);

CREATE TABLE IF NOT EXISTS Fournisseurs(
    codeFour VARCHAR(10) PRIMARY KEY NOT NULL,
    nomFour VARCHAR(50) NOT NULL,
    villeFour VARCHAR(50) NOT NULL,
    telFour INT(10) NULL,
    emailFour VARCHAR(50) NULL
    )ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
CREATE UNIQUE INDEX index_codeFour ON Fournisseurs(codeFour, nomFour, villeFour, telFour, emailFour);

INSERT INTO Fournisseurs(codeFour, nomFour, villeFour, telFour, emailFour)
VALUES
('F01', 'Toto', 'Yakro', 30640516, 'toto@toto.ci'),
('F02', 'Froto', 'Abidjan', 27232425, 'fatou@yahoo.fr'),
('F03', 'Fatou', 'Yakro', 30641815, NULL),
('F04', 'Mankou', 'Bouake', 31732526, 'froto@toto.ci'),
('F05', 'Sery', 'Yakro', 30741719,NULL);





CREATE TABLE IF NOT EXISTS Dates(
    dates TIMESTAMP PRIMARY KEY
    )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    
INSERT INTO Dates(dates)
VALUES
('2021-01-01'),
('2021-02-01'),
('2021-01-20'),
('2021-01-21'),
('2021-02-02');

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

INSERT INTO Commander(numAdh, refProd, dateCom, qteCom)
VALUES
('A01', 'P01', '2021-01-01', 12),
('A01', 'P02', '2021-01-01', 45),
('A01', 'P03', '2021-01-01', 21),
('A01', 'P04', '2021-01-01', 54),
('A02', 'P01', '2021-01-01', 21),
('A02', 'P07', '2021-01-01', 87),
('A02', 'P08', '2021-01-01', 43),
('A02', 'P04', '2021-01-01', 56),
('A03', 'P01', '2021-02-10', 32),
('A03', 'P05', '2021-02-10', 6),
('A03', 'P07', '2021-02-10', 78),
('A03', 'P04', '2021-02-10', 48),
('A04', 'P08', '2021-02-10', 90),
('A04', 'P09', '2021-02-10', 34),
('A04', 'P10', '2021-02-10', 56),
('A04', 'P04', '2021-02-10', 76),
('A05', 'P01', '2021-01-01', 54),
('A05', 'P02', '2021-01-01', 32),
('A05', 'P05', '2021-01-01', 21),
('A05', 'P10', '2021-01-01', 84),
('A01', 'P01', '2021-01-20', 10),
('A01', 'P02', '2021-01-20', 40),
('A01', 'P03', '2021-01-20', 20),
('A01', 'P04', '2021-01-20', 50),
('A02', 'P01', '2021-01-20', 20),
('A02', 'P07', '2021-01-20', 80),
('A02', 'P08', '2021-01-20', 40),
('A02', 'P04', '2021-01-20', 50),
('A03', 'P01', '2021-01-21', 30),
('A03', 'P05', '2021-01-21', 60),
('A03', 'P07', '2021-01-21', 70),
('A03', 'P04', '2021-01-21', 40),
('A04', 'P08', '2021-01-21', 95),
('A04', 'P09', '2021-01-21', 30),
('A04', 'P10', '2021-01-21', 50),
('A04', 'P04', '2021-01-21', 70),
('A05', 'P01', '2021-02-01', 50),
('A05', 'P02', '2021-02-01', 30),
('A05', 'P05', '2021-02-01', 20),
('A05', 'P10', '2021-02-01', 80);

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
    
    INSERT INTO DetailsLiv(codeFour, refProd, dateLiv, qteLiv, prixAchat) VALUES
('F01', 'P01', '2021-01-01', 120, 250),
('F01', 'P02', '2021-01-01', 450, 300),
('F01', 'P03', '2021-01-01', 210, 1500),
('F01', 'P04', '2021-01-01', 540, 3500),
('F02', 'P01', '2021-01-01', 210, 275),
('F02', 'P07', '2021-01-01', 870, 15000),
('F02', 'P08', '2021-01-01', 430, 350000),
('F02', 'P04', '2021-01-01', 560, 3000),
('F03', 'P01', '2021-02-10', 320, 2250),
('F03', 'P05', '2021-02-10', 60, 25000),
('F03', 'P07', '2021-02-10', 780, 16500),
('F03', 'P04', '2021-02-10', 480, 3450),
('F04', 'P08', '2021-02-10', 900, 345000),
('F04', 'P09', '2021-02-10', 340, 275000),
('F04', 'P10', '2021-02-10', 560, 15000),
('F04', 'P04', '2021-02-10', 760, 3500),
('F05', 'P01', '2021-01-01', 540, 290),
('F05', 'P02', '2021-01-01', 320, 375),
('F05', 'P05', '2021-01-01', 210, 27000),
('F05', 'P10', '2021-01-01', 840, 18500),
('F01', 'P01', '2021-01-20', 100, 255),
('F01', 'P02', '2021-01-20', 400, 305),
('F01', 'P03', '2021-01-20', 200, 1550),
('F01', 'P04', '2021-01-20', 500, 3505),
('F02', 'P01', '2021-01-20', 200, 285),
('F02', 'P07', '2021-01-20', 800, 15005),
('F02', 'P08', '2021-01-20', 400, 350005),
('F02', 'P04', '2021-01-20', 500, 3005),
('F03', 'P01', '2021-01-21', 300, 2255),
('F03', 'P05', '2021-01-21', 600, 25050),
('F03', 'P07', '2021-01-21', 700, 16505),
('F03', 'P04', '2021-01-21', 400, 3455),
('F04', 'P08', '2021-01-21', 950, 345005),
('F04', 'P09', '2021-01-21', 300, 275005),
('F04', 'P10', '2021-01-21', 500, 15005),
('F04', 'P04', '2021-01-21', 700, 3505),
('F05', 'P01', '2021-01-01', 500, 295),
('F05', 'P02', '2021-02-01', 300, 385),
('F05', 'P05', '2021-02-01', 200, 27005),
('F05', 'P10', '2021-02-01', 800, 18505);

