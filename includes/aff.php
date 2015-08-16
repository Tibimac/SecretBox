<?php
	if($nb_lines) // Si la requête dans list.php a retournée des enregistrements on a un objet à afficher
	{	
		if(isset($_GET['id']) && (!empty($_GET['id'])) && ($_GET['id']<=$nb_lines)) // Si id est défini dans l'url et qu'il n'est pas vide et qu'il est inférieur ou égal au nombre d'enregistrements total retournées par la requête
		{
			$num = $_GET['id'];
		}
		else
		{
			$num = "1";
		}
		
		$object_content = $db->requestSELECT("*", "EP3_$table_upper", "WHERE id_$table_lower = ".${$classe.$num}->id_secret,"","","",""); // Requête pour récupérer les valeurs de l'objet
	
		if($object_content) // Si la requête de sélection des données de l'objet a fonctionnée
		{
			$line = mysqli_fetch_assoc($object_content);

			switch($classe) // En fonction de l'objet a afficher, on choisir la bonne instanciation à faire
			{
				case "Licence": ${$classe.$num} = new Licence(${$classe.$num}->id_secret, ${$classe.$num}->titre, ${$classe.$num}->table, $line['application'], $line['version'], $line['description'], $line['societe'], $line['url'], $line['numero'], $line['clef'], $line['date_achat'], $line['nom'], $line['email'], $line['notes']);
					break;
				case "Site":    ${$classe.$num} = new Site(${$classe.$num}->id_secret, ${$classe.$num}->titre, ${$classe.$num}->table, $line['utilisateur'], $line['password'], $line['url'], $line['description']);
					break;
				case "Cb":      ${$classe.$num} = new Cb(${$classe.$num}->id_secret, ${$classe.$num}->titre, ${$classe.$num}->table, $line['titulaire'], $line['numero'], $line['date_expiration'], $line['type_cb']);
					break;
				case "Compte":  ${$classe.$num} = new Compte(${$classe.$num}->id_secret, ${$classe.$num}->titre, ${$classe.$num}->table, $line['banque_name'], $line['numero'], $line['type_compte']);
					break;
			}
			echo ${$classe.$num}->afficher(); // Appel à une méthode de la classe mère pour l'affichage des données de l'objet
		}
	}
?>