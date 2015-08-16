<?php
	$erreur_affichage = FALSE;
	
	if(isset($nb_lines))
	{
/*		$THE_URL=  $_SERVER['REQUEST_URI'];
		echo $THE_URL;
		$THE_URL = substr($THE_URL, strpos("index", $THE_URL));
		echo $THE_URL;
*/
		
		//	Cas "par defaut" : on arrive sur une page, pas d'id particulier de défini :
		//		- action vaut aff
		//		- id n'est pas défini
		if($action == "aff" && !isset($_GET['id']))
		{
            			
			if($nb_lines > 0) //Test pour définir si on a des élements et donc si on aura un objet d'affiché
			{
				$id_url = 1; //Aucun id de défini car cas par défaut, mais il y a des élement, donc l'id de l'élément affiché sera forcément le 1
				echo "<span id='titlebar-titre'><span class='nodisplay'><br/></span>".stripslashes(${$classe.$id_url}->titre)."</span>";
			}
			else //Sinon, aucun élément à afficher donc on n'affiche pas le boutton de suppression
			{
				$id_url = 0; 
			}
		}
		
		//	Cas où l'on a cliqué sur un élément de la liste pour l'afficher ou le modifier :
		//		- action vaut 'aff' ou 'edit'
		//		- id est défini
		//		- id n'est pas vide
		//		- id est numérique
		//		- id est inférieur ou égal au nombre de lignes
		elseif(($action == "aff" || $action == "edit") && isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] <= $nb_lines)
		{
			$id_url = $_GET['id']; // On a cliqué sur un élément à afficher = id défini, on récupère donc l'id de l'élément
			
			switch($action)
			{
				case "aff"	:	echo "<span id='titlebar-titre'><span class='nodisplay'><br/></span>".stripslashes(${$classe.$id_url}->titre)."</span>";
					break;
				
				case "edit" :	echo "<span id='titlebar-titre'><span class='nodisplay'><br/></span>Modification de ".stripslashes(${$classe.$id_url}->titre)."</span>";
					break;
				
				default : 		echo "<span id='titlebar-titre'><span class='nodisplay'><br/></span>".stripslashes(${$classe.$id_url}->titre)."</span>";
					break;
			}
		}
	
		//	Cas où l'on a cliqué sur le bouton d'ajout :
		//		- action vaut 'add'
		//		- id n'est pas défini
		elseif($action == "add" && !isset($_GET['id']))
		{
			$id_url = 0;
			echo "<span id='titlebar-titre'><span class='nodisplay'><br/></span>Ajout d'$particule $nom_item</span>";
		}
		
		// Cas qui ne correspond à aucun des cas de fonctionnement normal prévu. L'utilisateur a donc probablement modifié manuellement l'URL
		else
		{
			$id_url = 0;
			echo "<span class='error'><span class='nodisplay'><br/></span>Erreur : Ne modifiez pas l'url de la page svp !</span>";
			$erreur_affichage = TRUE;
		}
	}
	
	##########################################
	//		  Gestion des boutons			//
	##########################################
	// 	- action est 'aff'
	//	- id > à 0 et < au nombre de lignes
	if($action == "aff" && $id_url > 0 && $id_url <= $nb_lines)
	{
		if(isset($_GET['id'])) // Si l'id est dans l'URL on se base dessus
		{
			$object_title = stripslashes(${$classe.$_GET['id']}->titre);
			$objet_id = $_GET['id'];
		}
		else // Sinon on est sur le 1er élément
		{
			$object_title = stripslashes(${$classe."1"}->titre);
			$objet_id = 1;
		}
		
		// Gestion de l'orthographe (ex: une licence = la licence)
		if($particule == "une")
		{
			$article = "la";
		}
		elseif($particule == "un")
		{
			$article = "le";
		}
		?>
		
		<div id="btn-actions">
			<span class='nodisplay'>Imprimer <?= $object_title; ?> :</span>
			<button name="Imprimer" id="btn-print" value="" title="Imprimer <?= $object_title;?>" onClick="window.print()">
				<img src="./images/print.png" title="Imprimer" alt="Imprimer <?= $object_title;?>" class="nodisplay"/>
			</button>
		
			<!-- Renvoi vers la page d'édition avec l'id de l'objet à modifier -->
				<span class='nodisplay'>Modifier <?= $object_title; ?> :</span>
				<button onClick="window.location.replace('<?= "index.php?p=$p&action=edit&id=$objet_id"?>')" name="editButtonPushed" id="btn-edit" value="" title="Modifier <?= $object_title;?>">
					<img src="./images/edit.png" title="Modifier" alt="Modifier <?= $object_title; ?>" class="nodisplay"/>
				</button>
			
			<form method="POST" action="<?= $_SERVER['REQUEST_URI'];?>" onSubmit="return(confirm_delete('<?= $article; ?>','<?=$nom_item; ?>','<?= addslashes($object_title); ?>'));">
				<span class='nodisplay'>Supprimer <?= $object_title; ?> :</span>
				<button type="submit" name="deleteButtonPushed" id="btn-delete" value="" title="Supprimer <?= $object_title;?>">
					<img src="./images/delete.png" title="Supprimer" alt="Supprimer <?= $object_title;?>" class="nodisplay"/>
				</button>
				<?php if(isset($_POST['deleteButtonPushed']))
					{
						include_once('includes/delete.php');
					}?>
			</form>
		</div>
		<span class='nodisplay'><br/><br/></span>
<?php
	}
	?>
