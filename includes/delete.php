<?php
	if($nb_lines > 1) // Si nb_lines à plus d'une ligne
	{
		if(isset($_GET['id']) && $_GET['id']>1) // Et que on est sur un élément dont l'id est > 1
		{
			$id_to_aff = "&id=".($_GET['id']-1); // On affiche l'élément au dessus donc l'id inférieur
		}
		// Si on est sur le 1er élément (id défini et id = 1)
		// OU
		// Si on vient d'arriver sur la page aucun id n'est défini donc on est forcément sur le 1er élement donc on recharge juste la page pour automatiquement afficher l'élément en dessous
		elseif((isset($_GET['id']) && $_GET['id']==1) || (!isset($_GET['id']))) 
		{
			$id_to_aff = "";		// On affiche rien et automatiquement celui du dessous sera affiché
		}
	}
	elseif($nb_lines == 1) // Si nb_lines ne contient que 1 élément
	{
		$id_to_aff = ""; // Alors on est forcément sur cet élément unique, on recharge juste la page, le message disant qu'il n'y a aucun élément s'affichera
	}

	$erreur_message_delete = $db->requestDELETEObject(${$classe.$objet_id}); // Appel de la méthode de suppression (la variable objet_id vient de titlebar.php)
	
	if(isset($erreur_message_delete) && $erreur_message_delete != "") // Variable renvoyé par la méthode de suppresion, elle contient le message d'erreur à afficher s'il y a eut une erreur.
	{
		echo $erreur_message_delete;
	}
	else	// Si aucune erreur n'est renvoyé par la requête de suppression on peut alors recharger la bonne url
	{
		echo "<script type='text/javascript'>window.location.replace('index.php?p=$p$id_to_aff');</script>";
	}
?>