<?php
    // +=========================================+
	// |     Récupération Données de l'Objet     |
	// +=========================================+
	$id = $_GET['id'];
	
	//	Si on arrive après avoir cliqué sur le bouton d'édition
	// 		- $action = 'edit'
	if($action == "edit")
	{
		// On récupère depuis la base de donnée l'objet à éditer
		$object_content = $db->requestSELECT("*", "EP3_$table_upper INNER JOIN EP3_SECRET ON id_secret = id_$table_lower", "WHERE id_$table_lower = ".${$classe.$id}->id_secret,"","","","");
		$object_content = mysqli_fetch_assoc($object_content); // Création d'un tableau associatif
		traitementAffichage($p, $object_content); // Création des variables qui seront affichées dans les input par le formulaire
	}

    // +==================================+
	// |     Affichage du Formulaire      |
	// +==================================+?>
<form method="POST"action="<?= $_SERVER['REQUEST_URI'];?>">
	<?php
        //traitementAffichageForEdit($p, $_POST);
	 
	 	include("includes/forms/form_add_$p.php");
	 ?>
	<br/>
	<br/>
	<span class="nodisplay">Réinitialiser :</span><input type="reset" id="reset" value=" "/><span class="nodisplay">Enregistrer :</span><input type="submit" id="submit-save" name="saveEditButtonPushed" value =" " />
</form>
<br/>
<?php
	if(isset($_POST['saveEditButtonPushed']) && !empty($_POST['saveEditButtonPushed'])) // Si le bouton d'ajout a bien été cliqué
	{	  
        traitementAffichage($p, $_POST); // Création des variables pour chaque champs avec le $_POST, en cas d'erreur les valeurs restent alors affichées dans le formulaire
    	    	
    	// Si le titre est vide...
		if(empty($_POST['titre']))
		{
			// ... On affiche une erreur car il est obligatoire
			echo "<p class='error'>- Veuillez saisir un \"<span class='error' onClick=\"setFocus('titre')\">Titre</span>\" pour votre $nom_item, celui-ci est obligatoire.</p>";
		}
		
		// Vérification de la longueur et du type des champs
		$length_field_error_message = verifFieldsLength($p);
		$type_field_error_message = verifFieldsType($p);
		
		// Si problème, on a récupéré un message d'erreur donc on l'affiche
		if(!empty($length_field_error_message))
		{
			echo $length_field_error_message;
		}
		
		if(!empty($type_field_error_message))
		{
			echo $type_field_error_message;
		}
		
		// Si aucun soucis, on se lance dans l'enregistrement dans la base de données 
		if(!empty($_POST['titre']) && empty($length_field_error_message) && empty($type_field_error_message))
		{
			traitementPOST_AjoutBDD();
		
            // Enregistrement des nouvelles valeurs dans l'objet
			foreach($_POST as $key =>$valeur)
			{
				
				${$classe.$id}->$key = $valeur;
				
			}

			$update_object_error_message = $db->requestUPDATEObjet(${$classe.$id}); // Appel de la méthode d'insertion pour insérer l'objet
			
			if($update_object_error_message == "") // Si la méthode d'insertion de l'objet ne renvoi aucune erreur on rafraichit la page
			{
				echo "<script>";
				echo "reinitForm('$p');";
				echo "</script>";
				
				// Si le titre est modifié, l'élément peut changer de place dans la liste (triée par ordre alphabétique)
				// Pour retrouver l'id de l'élément, on récupérère la liste la liste des éléments du type de la page courante ds la BDD
				// On recherche ensuite dans les résultats l'emplacement de celui que l'on vient de modifier en comparant le titre de chaque résultat
				// avec le "nouveau" titre de l'élément que l'on vient de modifier.
				// Obligation de faire une requête sur la base car la page n'a pas encore été modifié tandis que la BDD elle vient de l'être, elle est donc à jour contrairement à la page qui n'a pas encore été rafraichie
				$table_content = $db->requestSELECT("titre", "EP3_SECRET INNER JOIN EP3_$table_upper ON id_secret = id_$table_lower", "", "", "", "ORDER BY titre ASC", "");
	
            	if($table_content) // Si la requête à réussie.
            	{
            		$nb_lines = mysqli_num_rows($table_content); // $nb_lines est affecté du nombre d'enregistrement retournés par la requête précédente.
            			
            		if($nb_lines) // Si la requête à retournée des résultat (au moins 1)
            		{	
                		if($nb_lines == 1) // Un seul élément dans cette section
                		{
                    		echo "<script type='text/javascript'>window.location.replace('index.php?p=$p&id=1');</script>";
                		}
                		else
                		{
                    		$cpt = 1;
                    		
                			while($line = mysqli_fetch_assoc($table_content)) // On parse tout les enregistrement retournés
                			{
                                if(${$classe.$id}->titre == $line['titre'])
                                {
                                    break;
                                }
                                
                                $cpt++;
                            }
                            
                            echo "<script type='text/javascript'>window.location.replace('index.php?p=$p&id=$cpt');</script>";
                        }
                    }
                    else // Aucun résultat renvoyé par la requête, forcément suite à une erreur car on vient de modifier un élément, il y a donc au moins 1 élément dans la BDD
                    {
                        // Tant pis on rafraichis la page en mode par défaut
        				echo "<script type='text/javascript'>window.location.replace('index.php?p=$p');</script>";
                    }
                }
				
				// Erreur de la requête, tant pis on rafraichis la page en mode par défaut
				echo "<script type='text/javascript'>window.location.replace('index.php?p=$p');</script>";
			}
			else
			{
				echo "<br/>".$update_object_error_message; // Sinon on affiche le message d'erreur renvoyé
			}
		}
	}
?>
