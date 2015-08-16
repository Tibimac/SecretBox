<form method="POST"action="index.php?p=<?php echo $p; ?>&action=add">
	<?php
		if(!empty($_POST))
		{
			traitementAffichage($p, $_POST);
		}
	 
	 	include("includes/forms/form_add_$p.php");
	 ?>
	<br/>
	<br/>
	<span class="nodisplay">Réinitialiser :</span><input type="reset" id="reset" value=" " onclick="reinitForm('<?php echo($p);?>')"/><span class="nodisplay">Enregistrer :</span><input type="submit" id="submit-save" name="addButtonPushed" value =" " />
</form>
<br/>
<?php
	if(isset($_POST['addButtonPushed']) && !empty($_POST['addButtonPushed'])) //Si le bouton d'ajout a bien été cliqué
	{	
    	traitementAffichage($p, $_POST); // Création des variables pour chaque champs avec le $_POST, en cas d'erreur les valeurs restent alors affichées dans le formulaire
    	
		if(empty($_POST['titre'])) //Si le champ de titre est vide
		{
			//Si le titre n'a pas été saisi alors qu'il est obligatoire on affiche une erreur
			echo "<p class='error'>- Veuillez saisir un \"<span class='error' onClick=\"setFocus('titre')\">Titre</span>\" pour votre $nom_item, celui-ci est obligatoire.</p>";
		}
		
		$length_field_error_message = verifFieldsLength($p);
		$type_field_error_message = verifFieldsType($p);
		
		if(!empty($length_field_error_message))
		{
			echo $length_field_error_message;
		}
		
		if(!empty($type_field_error_message))
		{
			echo $type_field_error_message;
		}
		
		if(!empty($_POST['titre']) && empty($length_field_error_message) && empty($type_field_error_message))
		{
			traitementPOST_AjoutBDD();
		
			switch($p) //Selon l'objet que l'on souhaite insérer on créer l'objer correspondant avec la bonne classe
			{
				case "l" :  $objet = new Licence("", $_POST['titre'], $table_upper, $_POST['application'], $_POST['version'], $_POST['description'], $_POST['societe'], $_POST['url'], $_POST['numero'], $_POST['clef'], $_POST['date_achat'], $_POST['nom'], $_POST['email'], $_POST['notes']);
					break;
				case "s" :  $objet = new Site("", $_POST['titre'], $table_upper, $_POST['utilisateur'], $_POST['password'], $_POST['url'], $_POST['description']);
					break;
				case "cb":  $objet = new Cb("", $_POST['titre'], $table_upper, $_POST['titulaire'], $_POST['numero'], $_POST['date_expiration'], $_POST['type_cb']);
					break;
				case "cp":  $objet = new Compte("", $_POST['titre'], $table_upper, $_POST['banque_name'], $_POST['numero'], $_POST['type_compte']);
					break;
			}
			
			$insert_object_error_message = $db->requestINSERTObjet($objet); //Appel de la méthode d'insertion pour insérer l'objet
			
			if($insert_object_error_message == "") //Si la méthode d'insertion de l'objet ne renvoi aucune erreur on rafraichit la page
			{
				echo "<script>";
				echo "reinitForm('$p');";
				echo "</script>";
				
				echo "<script type='text/javascript'>window.location.replace('index.php?p=$p&action=add');</script>";
			}
			else
			{
				echo "<br/>".$insert_object_error_message; //Sinon on affiche le message d'erreur renvoyé
			}
		}
	}
?>
