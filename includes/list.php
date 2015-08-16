<span class='nodisplay'><b><u>Liste des <?php echo $title; ?> :</u></b><br/></span>
<?php
#=== En fonction de la page sur laquelle on est et donc du type d'enregistrement que l'on va devoir afficher on détermine la table à parser dans la base de données ====#

	$table_content = $db->requestSELECT("*", "EP3_SECRET INNER JOIN EP3_$table_upper ON id_secret = id_$table_lower", "", "", "", "ORDER BY titre ASC", ""); //$table_content récupère tous les enregistrement de la table sur laquelle est faite la selection
	
	if($table_content) // Si la requête à réussie.
	{
		$nb_lines = mysqli_num_rows($table_content); // $nb_lines est affecté du nombre d'enregistrement retournés par la requête précédente.
			
		if($nb_lines) //Si la requête à retournée des résultat (au moins 1)
		{
			$num = 0;
			
			while($line = mysqli_fetch_assoc($table_content)) // On parse tout les enregistrement retournés
			{
				$num++;
				
				switch($p) // Instanciation d'un nouvel objet pour chaque résultat
                {
    				case "l" :  ${$classe.$num} = new Licence   ($line['id_secret'], $line['titre'], $table_upper, $line['application'], $line['version'],  $line['description'], $line['societe'], $line['url'], $line['numero'], $line['clef'], $line['date_achat'], $line['nom'], $line['email'], $line['notes']);
    					break;
    				case "s" :  ${$classe.$num} = new Site      ($line['id_secret'], $line['titre'], $table_upper, $line['utilisateur'], $line['password'], $line['url'], $line['description']);
    					break;
    				case "cb":  ${$classe.$num} = new Cb        ($line['id_secret'], $line['titre'], $table_upper, $line['titulaire'],   $line['numero'],   $line['date_expiration'], $line['type_cb']);
    					break;
    				case "cp":  ${$classe.$num} = new Compte    ($line['id_secret'], $line['titre'], $table_upper, $line['banque_name'], $line['numero'],   $line['type_compte']);
    					break;
			    }
			    
				//${$classe.$num} = new Secret($line['id_secret'], $line['titre'], $table_upper); // Instanciation d'un nouvel objet 
				echo "<a href='index.php?p=$p&id=$num'>".stripslashes(${$classe.$num}->titre)."</a><span class='nodisplay'><br/></span>"; // Affichage du titre de l'objet
			}
		}
		else // Si aucun enregistrement retournés, la table est vide, on l'indique à l'utilisateur
		{
		    echo "<span class='empty'>Auc$particule $nom_item<br/><br/>Pour en ajouter cliquez sur le bouton d'ajout en bas de cette colonne.</span>";
		}
	}
	else // Si la requête n'a pas réussi on affichage un message d'erreur à l'utilisateur
	{
		echo "<span class='error'>Une erreur est survenue.<br/><br/>La requête de sélection des données dans la base n'a pu être effectuée.<br/><br/>Numéro de l'erreur : ".mysqli_errno().".<br/>Message de l'erreur : ".mysqli_error()."</span>";
	}
?>