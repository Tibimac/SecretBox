CREATE TRIGGER `delete_secret_from_licence` BEFORE DELETE ON `LICENCE`
FOR EACH ROW
	BEGIN
		DECLARE identifiant INT(5);
		DECLARE title VARCHAR(50);

		SET identifiant = OLD.id_licence ;
		SELECT titre INTO title FROM SECRET WHERE id_secret = identifiant ;

		DELETE FROM SECRET WHERE id_secret = identifiant AND titre = title ;
		
	END ;//
		
		
CREATE TRIGGER `delete_secret_from_site` BEFORE DELETE ON `SITE`
FOR EACH ROW
	BEGIN
		DECLARE identifiant INT(5);
		DECLARE title VARCHAR(50);

		SET identifiant = OLD.id_site ;
		SELECT titre INTO title FROM SECRET WHERE id_secret = identifiant ;

		DELETE FROM SECRET WHERE id_secret = identifiant AND titre = title ;
		
	END ;//
		
  
CREATE TRIGGER `delete_secret_from_cb` BEFORE DELETE ON `CB`
FOR EACH ROW
	BEGIN
		DECLARE identifiant INT(5);
		DECLARE title VARCHAR(50);

		SET identifiant = OLD.id_cb ;
		SELECT titre INTO title FROM SECRET WHERE id_secret = identifiant ;

		DELETE FROM SECRET WHERE id_secret = identifiant AND titre = title ;
		
	END ;//
		
  
CREATE TRIGGER `delete_secret_from_compte` BEFORE DELETE ON `COMPTE`
FOR EACH ROW
	BEGIN
		DECLARE identifiant INT(5);
		DECLARE title VARCHAR(50);

		SET identifiant = OLD.id_compte ;
		SELECT titre INTO title FROM SECRET WHERE id_secret = identifiant ;

		DELETE FROM SECRET WHERE id_secret = identifiant AND titre = title ;
		
	END ;//