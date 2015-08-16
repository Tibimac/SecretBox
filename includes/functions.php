<?php
function isBrowser($browser)
{
	if(strpos($_SERVER['HTTP_USER_AGENT'], $browser))
	{
		$askedBrowser = true;
	}
	else
	{
		$askedBrowser = false;
	}
	
	return($askedBrowser);
}


function initVarsSwitchP()
{
	global $p, $title, $particule, $nom_item, $table_upper, $table_lower, $classe;

	if(isset($_GET['p']))
	{
		$p = $_GET['p'];
		
		switch($p)
		{
			case "l" : 	$title = "Licences";
						$particule = "une";
						$nom_item = "licence";
						$table_upper = "LICENCE";
						$table_lower = "licence";
						$classe = "Licence";
					break;
			case "s" :	$title = "Sites Web";
						$particule = "un";
						$nom_item = "site web";
						$table_upper = "SITE";
						$table_lower = "site";
						$classe = "Site";
					break;
			case "cb" :	$title = "Cartes Bancaires";
						$particule = "une";
						$nom_item = "carte bancaire";
						$table_upper = "CB";
						$table_lower = "cb";
						$classe = "Cb";
					break;
			case "cp" :	$title = "Comptes Bancaires";
						$particule = "un";
						$nom_item = "compte bancaire";
						$table_upper = "COMPTE";
						$table_lower = "compte";
						$classe = "Compte";
					break; 
			default :	$p = "l";				// Dans le cas ou $p est défini mais sur une valeure autre, pour éviter
						$title = "Licences";	// des erreurs on initialise les variables à leur valeur par défaut.
						$particule = "une";		
						$nom_item = "licence";
						$table_upper = "LICENCE";
						$table_lower = "licence";
						$classe = "Licence";
					break;
		}
	
	}
	else // Si $_GET['p'] n'est pas défini on initialise les variable avec leur valeur par défaut.
	{
		$p = "l";
		$title = "Licences";
		$particule = "une";
		$nom_item = "licence";
		$table_upper = "LICENCE";
		$table_lower = "licence";
		$classe = "Licence";
	}
}


function initAction()
{
	global $action;

	if(isset($_GET['action']) && !empty($_GET['action']) && !is_numeric($_GET['action']) && ($_GET['action'] == "aff" || $_GET['action'] == "add" || $_GET['action'] == "edit")) // Si action est defini, non vide, non numérique et est "aff", "add" ou "edit"
	{
		$action = $_GET['action'];
	}
	else // Sinon on initialise avec l'action par défaut
	{
		$action = "aff";
	}
}


function traitementAffichage($p, $tab)
{
	foreach($tab as $key => $var) // Pour chaque "case" du tableau POST
	{
		global ${$key};
		
		${$key} = $var;		
		${$key} = stripslashes(${$key}); // On retire les slash mis automatiquement pour qu'ils ne s'affichent pas dans les input
		$tab[$key] = ${$key};
	}
}


function traitementPOST_AjoutBDD()
{
	foreach($_POST as $key => $var)
	{		
		$_POST[''.$key.''] = addslashes($var);
    }
}


function verifFieldsLength($p)
{
	$error_length_field_message = "";
	$length_error = false; // Variable indiquant si une ou plusieurs erreur ont eut lieu et si donc un ou plusieurs champs sont trop long.
		
	switch($p)// En fonction de la page et donc l'objet en cours d'ajout, les champs a vérifier sont différent et leur taille maximum aussi, on crée donc un tableau associatif associant nom du champ a sa longueur maxi.
	{
		case "l" : $fieldsLength = array("titre" => "50", "application"=>"50", "version"=>"15", "societe"=>"75","url"=>"200","numero"=>"200","clef"=>"200","date_achat"=>"10", "nom"=>"100", "email"=>"150");
			break;
		case "s" : $fieldsLength = array("titre" => "50", "utilisateur"=>"35", "password"=>"50", "url"=>"200");
			break;
		case "cb" : $fieldsLength = array("titre" => "50", "titulaire"=>"75", "numero"=>"50", "date_expiration"=>"10", "type_cb"=>"25");
			break;
		case "cp" : $fieldsLength = array("titre" => "50", "banque_name"=>"50", "numero"=>"50", "type_compte"=>"50");
			break;
	}
	// Création d'un tableau pour donner la "traduction" des champs n'ayant pas le meme nom ds la base et ds les formulaires d'ajout/d'affichage
	$fieldsLocalized = array("url"=>"site Web","numero"=>"numéro", "password"=>"mot de passe","date_achat"=>"date d'achat", "date_expiration"=>"date d'expiration", "type_cb"=>"type", "banque_name"=>"Banque", "type_compte"=>"type");
	
	foreach($_POST as $key=>$var) // Parcours du tableau $_POST contenant les champs remplis
	{
		if(isset($fieldsLength[$key])) // Si le champs testé se trouve dans le tableau contenant tout les champs et leur taille repsective alors on test (les champs description et notes sont illimités et ne sont donc pas testés)
		{
			if(strlen($var) > $fieldsLength[''.$key.'']) // Si la longueur de la valeur du champ est plus longue que la longueur maxi indiquée ds le tableau on passe la variabl d'erreur a vrai et on stocke le nom du champ trop long
			{
			 	$length_error = true;
			 	$name_wrong_field[] = $key;
			}
		}
	}
	if($length_error) // S'il y a eut une erreur
	{
		$nb_wrong_field = sizeof($name_wrong_field); // On récupère le nombre d'élément ds le tableau pour savoir combien de champ sont trop long et adapter le emssage d'erreur en fonction de ca.
		
		if($nb_wrong_field == 1)// Cas où seul 1 champ est trop long
		{
			if(isset($fieldsLocalized[$name_wrong_field[0]])) // Si le champ trop long se trouvent aussi ds le tableau des champs "traduit" on récupère sa "traduction"
			{
				$name_field = $fieldsLocalized["".$name_wrong_field[0].""];
			}
			else
			{
				$name_field = $name_wrong_field[0];
			}
			
			$error_length_field_message = "<p class='error'>- Le champ \"<span class='error' onClick=\"setFocus('".$name_wrong_field[0]."')\">".ucfirst($name_field)."</span>\" est trop long, il doit faire ".$fieldsLength[$name_wrong_field[0]]." caractères maximum.</p>";
		}
		elseif($nb_wrong_field > 1)
		{
			$error_length_field_message = "<p class='error'>- Les champs ";
			
			for($i = 0; $i < $nb_wrong_field; $i++)
			{
				if(isset($fieldsLocalized[$name_wrong_field[$i]])) // Si le champ trop long se trouvent aussi ds le tableau des champs "traduit" on récupère sa "traduction"
				{
					$name_field = $fieldsLocalized["".$name_wrong_field[$i].""];
				}
				else
				{
					$name_field = $name_wrong_field[$i];
				}
				
				if($i == 0)
				{
					$error_length_field_message .="\"<span class='error' onClick=\"setFocus('".$name_wrong_field[$i]."')\">".ucfirst($name_field)."</span>\" (".$fieldsLength[$name_wrong_field[$i]].")";
				}
				elseif($i > 0 && $i < $nb_wrong_field-1)
				{
					$error_length_field_message .=", \"<span class='error' onClick=\"setFocus('".$name_wrong_field[$i]."')\">".ucfirst($name_field)."</span>\" (".$fieldsLength[$name_wrong_field[$i]].")";
				}
				elseif($i == $nb_wrong_field-1)
				{
					$error_length_field_message .=" et \"<span class='error' onClick=\"setFocus('".$name_wrong_field[$i]."')\">".ucfirst($name_field)."</span>\" (".$fieldsLength[$name_wrong_field[$i]].")";
				}
			}
			
			$error_length_field_message .= " sont trop long. Veuillez respecter la longueur indiquée entre parenthèse pour chacun des champs.</p>";
		}
	}
		
	unset($fieldsLengt);
	unset($name_field);
	
	return($error_length_field_message);
}


function verifFieldsType($p)
{
	$error_type_field_message = "";
	$type_error = false; // Variable indiquant si une ou plusieurs erreur ont eut lieu et si donc un ou plusieurs champs sont mauvais.
		
	switch($p)// En fonction de la page et donc l'objet en cours d'ajout, les champs a vérifier sont différent et leur taille maximum aussi, on crée donc un tableau associatif associant nom du champ a sa longueur maxi.
	{
		case "l" : $fieldsType = array("url", "date_achat", "email");
			break;
		case "s" : $fieldsType = array("url");
			break;
		case "cb" : $fieldsType = array("date_expiration", "numero");
			break;
		case "cp" : $fieldsType = array("numero");
			break;
	}
	// Création d'un tableau pour donner la "traduction" des champs n'ayant pas le meme nom ds la base et ds les formulaires d'ajout/d'affichage
	$fieldsLocalized = array("url"=>"site Web","numero"=>"numéro", "date_achat"=>"date d'achat", "date_expiration"=>"date d'expiration");
	
	foreach($_POST as $key => $var) // Parcours du tableau $_POST contenant les champs remplis
	{
		if(in_array($key, $fieldsType)) // Si le champs testé se trouve dans le tableau contenant tout les champs et leur taille repsective alors on test (les champs description et notes sont illimités et ne sont donc pas testés)
		{
			switch($key)
			{
				case "url" : 	if(!empty($var))
							{	
								if(! preg_match("#^www\.[a-zA-Z0-9._-]+\.[a-z]{2,4}(\/[a-zA-Z0-9-_.]){0,}#", $var))
								{
									$type_error = true;
									$name_wrong_field[] = $key;
								}
							}
					break;
					
				case "numero" :	if(!empty($var))
								{
									if(! is_numeric($var))
									{
										$type_error = true;
										$name_wrong_field[] = $key;
									}
								}
					break;
					
				case "email" :	if(!empty($var))
							{
								if(! preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $var))
								{
									$type_error = true;
									$name_wrong_field[] = $key;
								}
							}
					break;
					
				default :		if(!empty($var))
							{
								if(! preg_match("#^([0-9]{2,2}\/){2,2}[0-9]{4,4}$#", $var))
								{
									$type_error = true;
									$name_wrong_field[] = $key;
								}
								else
								{
									$day = substr($var, 0, 2);
									$month = substr($var, 3, 2);
									$year = substr($var, 6, 4);
								
									$dateValide = checkdate($month, $day, $year);
								
									if(! $dateValide)
									{
										$name_field = $fieldsLocalized[$key];
										$error_type_field_message .= "<p class='error'>- La <span class='error' onClick=\"setFocus('".$key."')\">".$name_field."</span> (".$var.") n'est pas une date valide.</p>";
									}
								}
							}
					break;
			}
		}
	}
	
	if($type_error) // S'il y a eut une erreur
	{
		$nb_wrong_field = sizeof($name_wrong_field); // On récupère le nombre d'élément ds le tableau pour savoir combien de champ sont trop long et adapter le emssage d'erreur en fonction de ca.
		
		if($nb_wrong_field == 1)// Cas où seul 1 champ est trop long
		{
			if($name_wrong_field[0] != "email") // Si le champ trop long se trouvent aussi ds le tableau des champs "traduit" on récupère sa "traduction"
			{
				$name_field = $fieldsLocalized["".$name_wrong_field[0].""];
			}
			else
			{
				$name_field = "email";
			}
			
			if(preg_match("#^date_#",$name_wrong_field[0]))
			{
				$prefixe = "La";
				$mot = "saisie";			
			}
			elseif($name_wrong_field[0] == "email")
			{
    			$prefixe = "L'";
    			$mot = "saisi";
			}
			else
			{
				$prefixe = "Le";
				$mot = "saisi";
			}
			
			$error_type_field_message .= "<p class='error'>- $prefixe \"<span class='error' onClick=\"setFocus('".$name_wrong_field[0]."')\">".ucfirst($name_field)."</span>\" $mot n'est pas valide.</p>";
		}
		elseif($nb_wrong_field > 1)
		{
			$error_type_field_message .= "<p class='error'>- Les champs ";
			
			for($i = 0; $i < $nb_wrong_field; $i++)
			{
				if(isset($fieldsLocalized[$name_wrong_field[$i]])) // Si le champ trop long se trouvent aussi ds le tableau des champs "traduit" on récupère sa "traduction"
				{
					$name_field = $fieldsLocalized["".$name_wrong_field[$i].""];
				}
				else
				{
					$name_field = $name_wrong_field[$i];
				}
				
				if($i == 0)
				{
					$error_type_field_message .="\"<span class='error' onClick=\"setFocus('".$name_wrong_field[$i]."')\">".ucfirst($name_field)."</span>\"";
				}
				elseif($i > 0 && $i < $nb_wrong_field-1)
				{
					$error_type_field_message .=", \"<span class='error' onClick=\"setFocus('".$name_wrong_field[$i]."')\">".ucfirst($name_field)."</span>\"";
				}
				elseif($i == $nb_wrong_field-1)
				{
					$error_type_field_message .=" et \"<span class='error' onClick=\"setFocus('".$name_wrong_field[$i]."')\">".ucfirst($name_field)."</span>\"";
				}
			}
			
			$error_type_field_message .= " ne sont pas valident.</p>";
		}
	}
		
	unset($fieldsType);
	unset($name_field);
	
	return($error_type_field_message);
}
?>