CREATE TABLE `SECRET`
(
  `id_secret` int(5) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50),
  PRIMARY KEY (`id_secret`)
);


CREATE TABLE `LICENCE`
(
  `id_licence` int(5) NOT NULL,
  `application` varchar(50),
  `version` varchar(15),
  `description` text,
  `societe` varchar(75),
  `url` varchar(200),
  `numero` varchar(100),
  `clef` varchar(100),
  `date_achat` varchar(10),
  `nom` varchar(100),
  `email` varchar(150),
  `notes` text,
  PRIMARY KEY (`id_licence`)
);


CREATE TABLE `SITE`
(
  `id_site` int(5) NOT NULL,
  `utilisateur` varchar(35),
  `password` varchar(50),
  `url` varchar(200),
  `description` text,
  PRIMARY KEY (`id_site`)
);

CREATE TABLE `CB`
(
  `id_cb` int(5) NOT NULL,
  `titulaire` varchar(75),
  `numero` varchar(50),
  `date_expiration` varchar(10),
  `type_cb` varchar(25),
  PRIMARY KEY (`id_cb`)
);

CREATE TABLE `COMPTE`
(
  `id_compte` int(5) NOT NULL,
  `banque_name` varchar(50),
  `numero` varchar(50),
  `type_compte` varchar(50),
  PRIMARY KEY (`id_compte`)
);