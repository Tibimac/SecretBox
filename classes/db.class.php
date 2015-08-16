<?php
	//+=========================================================+	
	//|						Classe Database						|		
	//+=========================================================+
	class Database
	{
		private $hote;
		private $base;
		private $login;
		private $password;
		private $link;
	
	
		##################
		// Constructeur //
		##################
		public function __construct()
		{
			$this->hote = "localhost";
			$this->login = "root";
			$this->password = "root";
			$this->base = "SecretBox";
			$this->database_connect(); //appel à la méthode de connexion pour créer la connexion lors de l'instanciation de l'objet
		}
		
		
		###############################################
		// Méthode de connexion à la base de données //
		###############################################
		private function database_connect()
		{
    		$this->link = mysqli_connect($this->hote, $this->login, $this->password, $this->base);
			mysqli_query($this->link, 'SET NAMES utf8');
			mysqli_query($this->link, 'SET CHARACTER SET utf8');
		}
	
	
		###############################################################
		// Méthode de fermeture de la connexion à la base de données //
		###############################################################
		public function database_close()
		{
			mysqli_close($this->link);
			unset($this);
		}
		
		
		public function __get($attribut) //On autorise seulement la récupération des attributs 'hote' et 'base'
		{	
			if(isset($attribut))
			{
				if($attribut == "hote" || $attribut == "base")
				{
					$attr = $this->$attribut;
				}
				else
				{
					$attr = 0; //Si l'attribut demandé est password ou login on renvoi une erreur
				}
			}
			else
			{
				$attr = 0; // Si l'attribut demandé n'existe pas on renvoi une erreur.
			}
			 
			return($attr); //Renvoi de a variable contenant soit la valeur de l'attribut demandé soit une erreur.
		}
		
		
		#####################################
		// Méthode de sélection de données //
		#####################################
		public function requestSELECT($values, $from, $where, $groupby, $having, $orderby, $limit)
		{
			$request = mysqli_query($this->link, "SELECT ".$values." FROM ".$from." ".$where." ".$groupby." ".$having." ".$orderby." ".$limit);
			
			return ($request);
		}
		
		
		####################################
		// Méthode d'insertion de données //
		####################################
		public function requestINSERTObjet($object)
		{			
			switch(get_class($object))// Détection de la classe de l'objet passé en paramètre 
			// En fonction de la classe les valeur à insérer dans la table change
			{
				case "Licence"	:	$values = "'".$object->application."', '".$object->version."', '".$object->description."', '".$object->societe."', '".$object->url."', '".$object->numero."', '".$object->clef."', '".$object->date_achat."', '".$object->nom."', '".$object->email."', '".$object->notes."'";
					break;
				case "Site" 	:	$values = "'".$object->utilisateur."', '".$object->password."', '".$object->url."', '".$object->description."'";
					break;
				case "Cb" 		:	$values = "'".$object->titulaire."', '".$object->numero."', '".$object->date_expiration."', '".$object->type_cb."'";
					break;
				case "Compte" 	:	$values = "'".$object->banque_name."', '".$object->numero."', '".$object->type_compte."'";
					break;
			}
			
			$erreur_message = "";

			$add_secret = mysqli_query($this->link, "INSERT INTO EP3_SECRET (titre) VALUES ('".$object->titre."')"); //Insertion du Secret dans la base
			
			if($add_secret) // Si la requête d'insertion du secret a réussi
			{
				$recup_id = mysqli_query($this->link, "SELECT id_secret FROM EP3_SECRET WHERE id_secret = (SELECT MAX(id_secret) FROM EP3_SECRET) and titre = '".$object->titre."'");
				//Requête pour sélectionner l'id du dernier secret créé, par sécurité on met une condition de vérification sur le titre
				
				if($recup_id) //Si la requête de récupération de l'id secret a réussi
				{
					$id = mysqli_fetch_assoc($recup_id); //On passe l'id dans une variable
					
					$add_objet = mysqli_query($this->link, "INSERT INTO EP3_".$object->table." VALUES ('".$id['id_secret']."', ".$values.")"); 
					//Requête d'ajout de notre objet dans la table correspondante aves les valeurs préalablement créées
					if(! $add_objet) //Si la requête d'ajout de l'objet a échoué
					{
						$erreur_message = "<br/><span class='error'>Erreur n°".mysqli_errno()." lors de l'insertion de l'objet \"".$object->titre."\". Message : ".mysqli_error()."</span><br/>";
					}
				}
				else //Si récupération de l'id secret a échoué
				{
					$erreur_message = "<br/><span class='error'>Erreur n°".mysqli_errno()." lors de la récupération de l'identifiant du secret. Message : ".mysqli_error()."</span><br/>";
				}
			}
			else //Si ajout du secret a échoué
			{
				$erreur_message = "<br/><span class='error'>Erreur n°".mysqli_errno()." lors de l'insertion du secret \"".$object->titre."\". Message : ".mysqli_error()."</span><br/>";
			}
			
			unset($add_secret);
			unset($recup_id);
			unset($add_objet);
			unset($id);
			
			return($erreur_message);
		}
		
		
		########################################
		// Méthode de modification de données //
		########################################
		public function requestUPDATEObjet($object)
		{
			switch(get_class($object))// Détection de la classe de l'objet passé en paramètre 
			// En fonction de la classe les valeur à modifier dans la table change
			{
				case "Licence"	:	$values = "application = '".$object->application."', version = '".$object->version."', description = '".$object->description."', societe = '".$object->societe."', url = '".$object->url."', numero = '".$object->numero."', clef = '".$object->clef."', date_achat = '".$object->date_achat."', nom = '".$object->nom."', email = '".$object->email."', notes = '".$object->notes."'";
					break;
				case "Site" 	:	$values = "utilisateur = '".$object->utilisateur."', password = '".$object->password."', url = '".$object->url."', description = '".$object->description."'";
					break;
				case "Cb" 		:	$values = "titulaire = '".$object->titulaire."', numero = '".$object->numero."', date_expiration = '".$object->date_expiration."', type_cb = '".$object->type_cb."'";
					break;
				case "Compte" 	:	$values = "banque_name = '".$object->banque_name."', numero = '".$object->numero."', type_compte = '".$object->type_compte."'";
					break;
			}
			
			$update_secret = mysqli_query($this->link, "UPDATE EP3_SECRET SET titre = '".$object->titre."' WHERE id_secret = ".$object->id_secret);
			
			if ($update_secret)
			{
    			$requete = "UPDATE EP3_".$object->table." SET ".$values." WHERE id_".strtolower($object->table)." = ".$object->id_secret;
    			
				$update_table = mysqli_query($this->link, "UPDATE EP3_".$object->table." SET ".$values." WHERE id_".strtolower($object->table)." = ".$object->id_secret);
				
				if (! $update_table)
				{
					$erreur_message = "<br/><span class='error'>Erreur n°".mysqli_errno()." lors de la mise à jour des valeurs du secret \"".$object->titre."\".</br>Message : ".mysqli_error()."</span><br/>";
				}
			}
			else
			{
				$erreur_message = "<br/><span class='error'>Erreur n°".mysqli_errno()." lors de la mise à jour du titre du secret \"".$object->titre."\".</br>Message : ".mysqli_error()."</span><br/>";
			}
			
			unset($update_secret);
			unset($update_table);
			
			return($erreur_message); //Renvoi du message d'erreur
		}
		
		
		#######################################
		// Méthode de suppression de données //
		#######################################
		public function requestDELETEObject($object)
		{
			$erreur_message = "";
			
			//Suppression du secret avec l'id de l'objet et son titre (sécurité)
			$delete_secret = mysqli_query($this->link, "DELETE FROM EP3_SECRET WHERE id_secret = '".$object->id_secret."' AND titre = '".addslashes($object->titre)."'");
			
			if($delete_secret)
			{
				//On supprime alors l'objet avec son id
				$delete_objet = mysqli_query($this->link, "DELETE FROM EP3_".$object->table." WHERE id_".strtolower($object->table)." = ".$object->id_secret."");
				
				if(!$delete_objet)
				{
					$erreur_message = "<span class='error'>Erreur n°".mysqli_errno()." lors de la suppression de l'objet. Message : ".mysqli_error()."</span><br/><br/>";
				}
			}
			else
			{
				$erreur_message = "<span class='error'>Erreur n°".mysqli_errno()." lors de la suppression du secret. Message : ".mysqli_error()."</span><br/><br/>";
			}
			//Libération des variables
			unset($delete_secret);
			unset($delete_objet);
			
			return($erreur_message);//Renvoi du message d'erreur
		}
	}
?>