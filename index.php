<?php session_start(); ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="fr" xml:lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="author" content="Thibault Le Cornec"/>
		<meta name="copyright" content="Thibault Le Cornec 2010-2015"/>
		<meta name="apple-itunes-app" content="app-id=568903335"/>
		<link rel="shortcut icon" href="favicon.ico"/>
	<?php
		// Inclusion du fichier contenant les fonctions PHP
		require_once('includes/functions.php');
		
		// +=============================+
		// |     GESTION NAVIGATEURS     |
		// +=============================+
		//	Redirection vers une page speciale pour ceux utilisant IE5 IE6 ou IE7
		//	Si le navigateur est IE 5 ou IE 6 ou IE 7 on envoi le visiteur sur une page autre car ces navigateurs sont obsoletes
		if(isBrowser('MSIE 5') || isBrowser('MSIE 6') || isBrowser('MSIE 7'))
			echo '<script type="text/javascript">window.location.replace(\'IE.html\');</script>';
		
		// +========================+
		// |     INITIALISATION     |
		// +========================+
		// !! == NE PAS DÉPLACER == !!
		// Appels des fonctions d'initialisation des variables de la page
		// Permet de definir des variables servant à l'inclusion de fichiers (CSS par exemple)
		initVarsSwitchP();
		initAction();
		
		// +=====================+
		// |     GESTION CSS     |
		// +=====================+
		// Detection du navigateur pour le choix du CSS principal
		if		(isBrowser('WebKit') || isBrowser('Firefox'))	{	echo '<link rel="stylesheet" type="text/css" href="designs/design.css" 	  media="screen"/>';	}
		else													{	echo '<link rel="stylesheet" type="text/css" href="designs/AltDesign.css" media="screen"/>';	}
		
		//  Si le navigateur n'utilise pas WebKit, on ajoute le CSS pour l'affichage de la div d'alerte
		if(!isBrowser('WebKit'))
		{
			echo "<link rel='stylesheet' type='text/css' href='designs/nowebkit.css'/>";
			$includeWebKitWarning = true; //Par cette variable on indique qu'il faudra inclure le fichier contenant la div d'alerte
		}

		//	Si on est sur l'affichage d'un élément, on ajoute le CSS 'print' utilisé par le bouton d'impression
		//	- action = 'aff' (même si pas défini en GET (voir initVarsSwitchP))
		if($action == "aff")
			echo '<link rel="stylesheet" type="text/css" href="designs/print-design.css" media="print"/>';
		
		//	Si on est sur une page d'ajout ou d'edition on ajoute les CSS du formulaire de la page correspondante
		//		- action = 'ad' ou 'edit'
		if($action == "add" || $action == "edit")
		{
			echo 	'<link rel="stylesheet" type="text/css" href="designs/forms/forms.css"/>';
			echo 	"<link rel='stylesheet' type='text/css' href='designs/forms/form_$p.css'/>";
			//Si on est sur une page d'ajout la balise body appellera une fonction JS sur l'evenement onload
			$functionJStoAddForm = 'onload="setFocus(\'titre\')"';
		}
	?>
		<title><?= "SecretBox | $title";?></title>
		<script type="text/javascript" src="includes/functions.js"></script>
	</head>
	
	
	<body <?php if(isset($functionJStoAddForm)){echo $functionJStoAddForm;} // Si la variable est definie, c'est que page est 'add', on doit faire appel à la fonction JS pour mettre le focus sur le champ Titre ?>>
	
	<?php
    	if(!isset($_SESSION['alerteWebKitDisplayed'])) // Si la variable n'existe pas alors l'alerte WebKit n'a pas encore été affichée
        {
            if(isset($includeWebKitWarning)) // Si cette variable est définie alors le navigateur n'utilise pas le WebKit et on doit afficher l'alerte WebKit
            {
				include_once('includes/notWebKit.html'); // Inclusion message indiquant que le design de l'application web est optimisé pour WebKit (Safari et Chrome)
				$_SESSION['alerteWebKitDisplayed'] = true; // Par cette variable de session on indique que le message d'alerte à deja été affiché
			}
		}
	
		//+========================================================+
		//|########## ===== INCLUSION DES CLASSES ====== ##########|
		//+========================================================+		
		require_once('classes/db.class.php');
		require_once('classes/secret.class.php');
		require_once('classes/licence.class.php');
		require_once('classes/site.class.php');
		require_once('classes/cb.class.php');
		require_once('classes/compte.class.php');
		
		##### BASE DE DONNÉES #####
		$db = new Database(); // Nouvelle instance de 'Database' pour l'interconnexion avec la base de données
	
		//	L'affichage est adapté de manière adéquate en fonction de si des éléements existent ou non pour le type de catégorie sur laquelle nous sommes
		//	Pour cela, une requête sélectionne, dans la table liée à la catégorie actuelle, l'ensemble des éléments 
		//	Puis récupère le nombre d'éléments récupérés (peut être 0)
		$nb_elem = $db->requestSELECT("*", "EP3_".$table_upper, NULL, NULL, NULL, NULL, NULL);
		$nb_elem = mysqli_num_rows($nb_elem);
		
		if($nb_elem > 0) // Si on a des éléments, une div d'affichage du nombre d'élément sera affichée
		{
			$classe_sidebarlist = "top-bas"; // La liste les éléments débutera donc plus bas --> classe CSS = 'top-bas'
			
			// Adaptation de l'orthographe de la catégorie en fonction du nombre d'élément
			if($nb_elem > 1)
			{
				$elemsName = strtolower($title); // le nom contient un 's'
			}
			else
			{
				switch($p) // le nom ne contiendra pas de 's'
				{
					case "l"    : $elemsName = "licence";           break;
					case "s"    : $elemsName = "site web";          break;
					case "cb"   : $elemsName = "carte bancaire";    break;
					case "cp"   : $elemsName = "compte bancaire";   break;
				}
			}
			echo "<!--Liste --><div id='nb-elem'><p>$nb_elem $elemsName</p></div>"; // DIV d'affichage du nombre d'éléments dans la catégorie
		}
		else // Aucun élément, la div n'est pas affichée, la liste commence plus haut --> classe CSS = 'top-haut'
		{
		 	$classe_sidebarlist = "top-haut";
		}
	?>
		<!-- SideBar - Liste Éléments -->
		<div id="sidebar_list" class="<?= $classe_sidebarlist;?>">
			<?php require_once('includes/list.php');?>
		</div>
		
		<!-- Barre Horizontale -->
		<div id="bar">
			<!-- Séparateur -->
			<div id="separator"></div>
			
			<!-- Barre | Titre / Boutons -->
			<div id="titlebar">
				<?php require_once('includes/titlebar.php');?>
			</div>
		</div>
		
		<!-- Contenu -->
		<div id="content">
			<?php
				// En fonction de la variable 'action' ('aff' par défaut - voir fonction initVarsSwitchP) la page PHP correspondante est chargée
				//	C'est cette page qui se chargera de faire l'action demandée avec le contenu correspondant à la catégorie sur laquelle on est (définie par la variable 'p')
				if(!$erreur_affichage) // Variable renvoyée par titlebar.php si l'URL a été modifiée (par l'utilisateur)
				{	
					$page = "includes/".$action.".php";
					
					if(file_exists($page))
					{
						require_once($page);
					}
					// Si la page demandée (par la variable 'action') n'existe : erreur
					else
					{
						include("includes/erreur.php");
					}
				}
				else
				{
					include("includes/erreur.php");
				}
			?>		
		</div>
		
		<!-- SideBar - Bouton Ajout -->		
		<div id="toolbar">
			<span class="nodisplay"><br/></span><a href="<?= "index.php?p=$p&action=add"?>" title="Ajouter <?= "$particule $nom_item"; ?>"><img src="images/add.png" alt="Ajouter <?= "$particule $nom_item"; ?>"/>Ajouter <?= $particule.' '.$nom_item;?></a>
		</div>
		
		<!-- Barre Horizontale - Menu -->
		<div id="sidebar_menu">
			<span class="nodisplay"><br/><br/><b><u>Menu :</u></b></span>
			<?php require_once('includes/menu.php');?>
		</div>
		
		<?php $db->database_close();	/*Fermeture de la connexion à la base de données*/ ?>
	</body>
</html>
