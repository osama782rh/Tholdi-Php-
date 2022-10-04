
create table devis
  (codeDevis INT NOT NULL,
  dateDevis bigint(20),
  montantDevis DECIMAL (6,2),
  volume  DECIMAL(4),
  nbContainers DECIMAL (11),
  valider INT (5),
  primary key (`codeDevis`)
  ) engine = innodb ;



  create table duree
	( codeDuree  VARCHAR (20) NOT NULL,
	 nbjours     INT (6),
  primary key (`codeDuree`)
	)engine = innodb ;



create table pays
  (codePays CHAR(4) NOT NULL,
  nomPays CHAR (30),
  primary key (`codePays`)
  )engine = innodb ;




create table ville
  (codeVille DECIMAL (6) NOT NULL,
  nomVille CHAR (30),
  codePays CHAR(4) NOT NULL,
  primary key (`codeVille`),
  FOREIGN KEY (codePays)REFERENCES pays(codePays)
  ) engine = innodb ;




create table utilisateur
  (codeUtilisateur INT(6) AUTO_INCREMENT,
  raisonSociale varCHAR (50),
  adresse CHAR (50),
  cp varchar(20),
  ville CHAR (40),
  adrMel varchar(100) NOT NULL,
  telephone Varchar (20),
  contact CHAR (50),
  codePays CHAR(4) NOT NULL,
  login  varchar(100) NOT NULL,
  mdp text NOT NULL,
  ip varchar(20),
  token text ,
  date_inscription bigint,
  primary key (`codeUtilisateur`),
  FOREIGN KEY (codePays)REFERENCES pays(codePays)
  )engine = innodb ;



create table reservation
  (codeReservation INT (100)  AUTO_INCREMENT,
  dateDebutReservation BIGINT(20),
  dateFinReservation  BIGINT(20),
  dateReservation BIGINT(20),
  volumeEstime DECIMAL (4),
  codeDevis INT,
  codeVille DECIMAL (6) null,
  codeVilleMiseDisposition INT(10),
  codeVilleRendre INT(10),
  codeUtilisateur INT(6) NOT NULL,
  numeroDeReservation DECIMAL (11),
  etat CHAR (10),
  primary key (`codeReservation`),
  FOREIGN KEY (codeVille) REFERENCES ville(codeVille),
  FOREIGN KEY (codeUtilisateur) REFERENCES utilisateur(codeUtilisateur)
  ) engine = innodb ;



create table typeContainer
	(numTypeContainer INT(6) NOT NULL,
	 codeTypeContainer  CHAR  (4),
	libelleTypeContainer CHAR (50),
	longueurCont DECIMAL(5),
  largeurCont DECIMAL(5),
  hauteurCont DECIMAL(4),
  poidsCont DECIMAL(5),
  tare  DECIMAL(4),
  capaciteDeCharge FLOAT (8,2),
  primary key (`numTypeContainer`)
	)engine = innodb ;



create table reserver
  ( codeReservation INT (100) NOT NULL,
   numTypeContainer INT(6)NOT NULL,
   qteReserver   INT(10),
   primary key (`codeReservation`,`numTypeContainer`),
   FOREIGN KEY (codeReservation)REFERENCES reservation(codeReservation),
   FOREIGN KEY (numTypeContainer)REFERENCES typeContainer(numTypeContainer)
   )engine = innodb ;



create table tarificationContainer
  (codeDuree VARCHAR (20),
    numTypeContainer INT(6),
    tarif DECIMAL(10,2),
    primary key (`codeDuree`,`numTypeContainer`),
    FOREIGN KEY (numTypeContainer)REFERENCES typeContainer(numTypeContainer)
   )engine = innodb ;